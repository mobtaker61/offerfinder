<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Market;
use App\Models\Emirate;
use App\Models\Offer;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $branches = Branch::with(['users', 'market'])->get();
            $markets = Market::all();
            $availableBranchAdmins = User::where('user_type', User::TYPE_BRANCH_ADMIN)->get();
            return view('admin.branch.index', compact('branches', 'markets', 'availableBranchAdmins'));
        } catch (\Exception $e) {
            Log::error('Error fetching branches', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to fetch branches: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $markets = Market::where('is_active', true)->get();
        $emirates = Emirate::all();
        $branchAdmins = User::where('user_type', User::TYPE_BRANCH_ADMIN)->get();
        return view('admin.branch.create', compact('markets', 'emirates', 'branchAdmins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'market_id' => 'required|exists:markets,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_active' => 'boolean',
            'contact_profiles' => 'required|array|min:1',
            'contact_profiles.*.type' => 'required|in:phone,cell,whatsapp,email',
            'contact_profiles.*.value' => 'required|string',
            'contact_profiles.*.is_primary' => 'boolean',
            'emirate_id' => 'required|exists:emirates,id',
            'district_id' => 'required|exists:districts,id',
            'neighbours' => 'required|array|min:1',
            'neighbours.*' => 'exists:neighbours,id',
            'branch_admin_id' => 'nullable|exists:users,id'
        ]);

        $branch = Branch::create($validated);

        // Handle branch admin assignment
        if ($request->has('branch_admin_id')) {
            $branch->users()->sync([$request->branch_admin_id]);
        }

        // Handle contact profiles
        foreach ($request->contact_profiles as $profile) {
            $branch->contactProfiles()->create($profile);
        }

        // Handle neighbours
        $branch->neighbours()->sync($request->neighbours);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch)
    {
        $markets = Market::where('is_active', true)->get();
        $emirates = Emirate::all();
        $branchAdmins = User::where('user_type', User::TYPE_BRANCH_ADMIN)->get();
        return view('admin.branch.edit', compact('branch', 'markets', 'emirates', 'branchAdmins'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'market_id' => 'required|exists:markets,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_active' => 'boolean',
            'contact_profiles' => 'required|array|min:1',
            'contact_profiles.*.type' => 'required|in:phone,cell,whatsapp,email',
            'contact_profiles.*.value' => 'required|string',
            'contact_profiles.*.is_primary' => 'boolean',
            'emirate_id' => 'required|exists:emirates,id',
            'district_id' => 'required|exists:districts,id',
            'neighbours' => 'required|array|min:1',
            'neighbours.*' => 'exists:neighbours,id',
            'branch_admin_id' => 'nullable|exists:users,id'
        ]);

        $branch->update($validated);

        // Handle branch admin assignment
        if ($request->has('branch_admin_id')) {
            $branch->users()->sync([$request->branch_admin_id]);
        } else {
            $branch->users()->detach();
        }

        // Handle contact profiles
        $branch->contactProfiles()->delete();
        foreach ($request->contact_profiles as $profile) {
            $branch->contactProfiles()->create($profile);
        }

        // Handle neighbours
        $branch->neighbours()->sync($request->neighbours);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        try {
            Log::info('Attempting to delete branch', ['branch_id' => $branch->id]);

            DB::beginTransaction();

            // Delete contact profiles first
            $branch->contactProfiles()->delete();
            
            // Delete the branch
            $branch->delete();

            DB::commit();
            Log::info('Branch deleted successfully', ['branch_id' => $branch->id]);

            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Branch deletion failed', [
                'branch_id' => $branch->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to delete branch: ' . $e->getMessage());
        }
    }

    // API methods for frontend
    public function getBranchesByMarketAndEmirate(Request $request)
    {
        try {
            $marketId = $request->query('market_id');
            $emirateId = $request->query('emirate_id');

            $branches = Branch::where('market_id', $marketId)
                             ->where('emirate_id', $emirateId)
                             ->where('is_active', true)
                             ->get();

            $branchIds = $branches->pluck('id');
            $offers = Offer::whereHas('branches', function($query) use ($branchIds) {
                $query->whereIn('branch_id', $branchIds);
            })->get();

            return response()->json(['branches' => $branches, 'offers' => $offers]);
        } catch (\Exception $e) {
            Log::error('Error fetching branches by market and emirate', [
                'market_id' => $marketId ?? null,
                'emirate_id' => $emirateId ?? null,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to fetch branches'], 500);
        }
    }

    public function getOffersByBranch(Request $request)
    {
        try {
            $branchId = $request->query('branch_id');

            $offers = Offer::whereHas('branches', function($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })->get();

            return response()->json(['offers' => $offers]);
        } catch (\Exception $e) {
            Log::error('Error fetching offers by branch', [
                'branch_id' => $branchId ?? null,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to fetch offers'], 500);
        }
    }

    public function getBranchesByMarket(Request $request)
    {
        try {
            $branches = Branch::where('market_id', $request->market_id)
                             ->where('is_active', true)
                             ->get();
            return response()->json(['branches' => $branches]);
        } catch (\Exception $e) {
            Log::error('Error fetching branches by market', [
                'market_id' => $request->market_id ?? null,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to fetch branches'], 500);
        }
    }

    // API methods for fetching districts and neighbours
    public function getDistricts(Emirate $emirate)
    {
        try {
            $districts = $emirate->districts()->orderBy('name')->get();
            return response()->json($districts);
        } catch (\Exception $e) {
            Log::error('Error fetching districts', [
                'emirate_id' => $emirate->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to fetch districts'], 500);
        }
    }

    public function getNeighbours(District $district)
    {
        try {
            $neighbours = $district->neighbours()->orderBy('name')->get();
            return response()->json($neighbours);
        } catch (\Exception $e) {
            Log::error('Error fetching neighbours', [
                'district_id' => $district->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to fetch neighbours'], 500);
        }
    }

    /**
     * Get the list of admins for a specific branch
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdmins(Branch $branch)
    {
        try {
            // Get current admins
            $currentAdmins = $branch->users()
                ->where('user_type', User::TYPE_BRANCH_ADMIN)
                ->select('users.id', 'users.name', 'users.email', 'users.is_active')
                ->get();

            // Get available admins (users who are not already admins of this branch)
            $availableAdmins = User::where('user_type', User::TYPE_BRANCH_ADMIN)
                ->whereDoesntHave('branches', function($query) use ($branch) {
                    $query->where('branches.id', $branch->id);
                })
                ->where('is_active', true)
                ->select('id', 'name', 'email')
                ->get();

            return response()->json([
                'success' => true,
                'currentAdmins' => $currentAdmins,
                'availableAdmins' => $availableAdmins
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load admin data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assign an admin to a branch
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignAdmin(Request $request, Branch $branch)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $user = User::findOrFail($request->user_id);
            
            if ($user->user_type !== User::TYPE_BRANCH_ADMIN) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected user is not a branch admin'
                ], 400);
            }

            $branch->users()->attach($user->id);

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

    /**
     * Remove an admin from a branch
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAdmin(Request $request, Branch $branch)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $branch->users()->detach($request->user_id);

            return response()->json([
                'success' => true,
                'message' => 'Admin removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove admin: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the list of contacts for a specific branch
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContacts(Branch $branch)
    {
        try {
            $contacts = $branch->contactProfiles()
                ->select('id', 'type', 'value', 'is_primary')
                ->orderBy('is_primary', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'contacts' => $contacts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load contact data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the list of areas for a specific branch
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAreas(Branch $branch)
    {
        try {
            $areas = [];
            
            // Get the branch's emirate and district
            $emirate = $branch->emirate;
            $district = $branch->district;
            
            if ($emirate && $district) {
                // Get all neighbours for this branch
                $neighbours = $branch->neighbours()
                    ->select('id', 'name')
                    ->get();
                
                // Organize the data by emirate and district
                $areas[$emirate->name] = [
                    $district->name => $neighbours->pluck('name')->toArray()
                ];
            }

            return response()->json([
                'success' => true,
                'areas' => $areas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load areas data: ' . $e->getMessage()
            ], 500);
        }
    }
} 