<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Market;
use App\Models\Emirate;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $query = Branch::query();

        if ($request->has('market_id')) {
            $query->where('market_id', $request->market_id);
        }
        $branches = $query->paginate(10);
        return view('admin.branch.index', compact('branches'));
    }

    public function create()
    {
        $markets = Market::all();
        $emirates = Emirate::all();

        return view('admin.branch.create', compact('markets', 'emirates'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Branch store request received', [
                'request_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'market_id' => 'required|exists:markets,id',
                'address' => 'nullable|string',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'is_active' => 'boolean',
                'contact_profiles' => 'array',
                'contact_profiles.*.type' => 'required|in:phone,cell,whatsapp,email',
                'contact_profiles.*.value' => 'required|string',
                'contact_profiles.*.is_primary' => 'nullable|boolean',
            ]);

            DB::beginTransaction();

            $branch = Branch::create([
                'name' => $validated['name'],
                'market_id' => $validated['market_id'],
                'address' => $validated['address'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'is_active' => $request->boolean('is_active', true),
            ]);
            sendToTelegram('Branch stored = ' . json_encode($branch));

            Log::info('Branch created', ['branch_id' => $branch->id]);

            // Create contact profiles
            foreach ($validated['contact_profiles'] as $profile) {
                $contactProfile = $branch->contactProfiles()->create([
                    'type' => $profile['type'],
                    'value' => $profile['value'],
                    'is_primary' => isset($profile['is_primary']) && $profile['is_primary'] == '1',
                ]);
                Log::info('Contact profile created', ['contact_profile_id' => $contactProfile->id]);
            }

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('admin.branches.index')->with('success', 'Branch created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Branch creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Failed to create branch: ' . $e->getMessage());
        }
    }

    public function edit(Branch $branch)
    {
        $markets = Market::all();
        $emirates = Emirate::all();
        return view('admin.branch.edit', compact('branch', 'markets', 'emirates'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'market_id' => 'required|exists:markets,id',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_active' => 'boolean',
            'contact_profiles' => 'required|array',
            'contact_profiles.*.type' => 'required|in:phone,cell,whatsapp,email',
            'contact_profiles.*.value' => 'required|string',
            'contact_profiles.*.is_primary' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $branch->update([
                'name' => $request->name,
                'market_id' => $request->market_id,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Delete existing contact profiles
            $branch->contactProfiles()->delete();

            // Create new contact profiles
            foreach ($request->contact_profiles as $profile) {
                $branch->contactProfiles()->create([
                    'type' => $profile['type'],
                    'value' => $profile['value'],
                    'is_primary' => isset($profile['is_primary']),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.branches.index')->with('success', 'Branch updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update branch: ' . $e->getMessage());
        }
    }

    public function destroy(Branch $branch)
    {
        try {
            $branch->delete();
            return redirect()->route('admin.branches.index')->with('success', 'Branch deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete branch: ' . $e->getMessage());
        }
    }

    // API methods for frontend
    public function getBranchesByMarketAndEmirate(Request $request)
    {
        $marketId = $request->query('market_id');
        $emirateId = $request->query('emirate_id');

        $branches = Branch::where('market_id', $marketId)
                          ->where('emirate_id', $emirateId)
                          ->get();

        $branchIds = $branches->pluck('id');
        $offers = Offer::whereHas('branches', function($query) use ($branchIds) {
            $query->whereIn('branch_id', $branchIds);
        })->get();

        return response()->json(['branches' => $branches, 'offers' => $offers]);
    }

    public function getOffersByBranch(Request $request)
    {
        $branchId = $request->query('branch_id');

        $offers = Offer::whereHas('branches', function($query) use ($branchId) {
            $query->where('branch_id', $branchId);
        })->get();

        return response()->json(['offers' => $offers]);
    }

    public function getBranchesByMarket(Request $request)
    {
        $branches = Branch::where('market_id', $request->market_id)->get();
        return response()->json(['branches' => $branches]);
    }
} 