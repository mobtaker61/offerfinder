<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Plan;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $markets = Market::with(['users', 'plan'])->latest()->paginate($perPage);
            $availableMarketAdmins = User::where('user_type', User::TYPE_MARKET_ADMIN)->get();
            return view('admin.market.index', compact('markets', 'availableMarketAdmins'));
        } catch (\Exception $e) {
            Log::error('Error fetching markets', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to fetch markets');
        }
    }

    public function create()
    {
        $marketAdmins = User::where('user_type', User::TYPE_MARKET_ADMIN)->get();
        $plans = Plan::where('is_active', true)->orderBy('name')->get();
        return view('admin.market.create', compact('marketAdmins', 'plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'android_app_link' => 'nullable|url',
            'ios_app_link' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|max:1024',
            'avatar' => 'nullable|image|max:1024',
            'market_admin_id' => 'nullable|exists:users,id',
            'plan_id' => 'nullable|exists:plans,id'
        ]);

        $market = Market::create($validated);

        // Handle market admin assignment
        if ($request->has('market_admin_id')) {
            $market->users()->sync([$request->market_admin_id]);
        }

        return redirect()->route('admin.markets.index')
            ->with('success', 'Market created successfully.');
    }

    public function edit(Market $market)
    {
        $marketAdmins = User::where('user_type', User::TYPE_MARKET_ADMIN)->get();
        $plans = Plan::where('is_active', true)->orderBy('name')->get();
        return view('admin.market.edit', compact('market', 'marketAdmins', 'plans'));
    }

    public function update(Request $request, Market $market)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'android_app_link' => 'nullable|url',
            'ios_app_link' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|max:1024',
            'avatar' => 'nullable|image|max:1024',
            'market_admin_id' => 'nullable|exists:users,id',
            'plan_id' => 'nullable|exists:plans,id'
        ]);

        $market->update($validated);

        // Handle market admin assignment
        if ($request->has('market_admin_id')) {
            $market->users()->sync([$request->market_admin_id]);
        } else {
            $market->users()->detach();
        }

        return redirect()->route('admin.markets.index')
            ->with('success', 'Market updated successfully.');
    }

    public function destroy(Market $market) {
        if ($market->logo) {
            Storage::disk('public')->delete($market->logo);
        }
        if ($market->avatar) {
            Storage::disk('public')->delete($market->avatar);
        }
        $market->delete();

        return redirect()->route('admin.markets.index')->with('success', 'Market deleted successfully.');
    }

    public function toggleStatus(Request $request, Market $market)
    {
        $market->is_active = $request->boolean('is_active');
        $market->save();

        return response()->json([
            'success' => true,
            'message' => 'Market status updated successfully.'
        ]);
    }

    public function getMarketsByEmirate(Request $request)
    {
        $markets = Market::whereHas('branches', function ($query) use ($request) {
            $query->where('emirate_id', $request->emirate_id);
        })->get();

        return response()->json(['markets' => $markets]);
    }

    // Add this method to get branches for a market
    public function getBranches(Market $market)
    {
        try {
            $branches = Branch::where('market_id', $market->id)
                ->where('is_active', true)
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

            return response()->json($branches);
        } catch (\Exception $e) {
            Log::error("Error fetching branches: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch branches'], 500);
        }
    }

    public function assignAdmin(Request $request, Market $market)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $user = User::findOrFail($request->user_id);
            
            if ($user->user_type !== User::TYPE_MARKET_ADMIN) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected user is not a market admin'
                ], 400);
            }

            $market->users()->attach($user->id);

            return response()->json([
                'success' => true,
                'message' => 'Admin assigned successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign admin: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeAdmin(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $market = Market::findOrFail($id);
        $market->users()->detach($request->user_id);

        return response()->json([
            'success' => true,
            'message' => 'Admin removed successfully'
        ]);
    }

    /**
     * Get market admins and available admins for AJAX request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdmins($id)
    {
        try {
            $market = Market::with('users')->findOrFail($id);
            
            // Get all users with market_admin type who aren't already assigned to this market
            $availableAdmins = User::where('user_type', User::TYPE_MARKET_ADMIN)
                ->whereDoesntHave('markets', function($query) use ($id) {
                    $query->where('markets.id', $id);
                })
                ->where('is_active', 1)
                ->get(['id', 'name', 'email', 'is_active']);
            
            // Get current market admins
            $currentAdmins = $market->users()->get(['users.id', 'name', 'email', 'is_active']);
            
            return response()->json([
                'success' => true,
                'availableAdmins' => $availableAdmins,
                'currentAdmins' => $currentAdmins
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load admin data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assign a plan to a market
     */
    public function assignPlan(Request $request, Market $market)
    {
        try {
            $request->validate([
                'plan_id' => 'required|exists:plans,id'
            ]);
            
            $market->plan_id = $request->plan_id;
            $market->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Plan assigned successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign plan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a plan from a market
     */
    public function removePlan(Market $market)
    {
        try {
            $market->plan_id = null;
            $market->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Plan removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove plan: ' . $e->getMessage()
            ], 500);
        }
    }
}
