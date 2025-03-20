<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Market;
use App\Models\Emirate;
use App\Models\Offer;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BranchController extends Controller
{
    public function index()
    {
        try {
            $branches = Branch::with(['market', 'contactProfiles', 'neighbours.district.emirate'])
                ->orderBy('name')
                ->get();
            
            $markets = Market::orderBy('name')->get();

            return view('admin.branch.index', compact('branches', 'markets'));
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
        try {
            $markets = Market::orderBy('name')->get();
            $emirates = Emirate::orderBy('name')->get();

            return view('admin.branch.create', compact('markets', 'emirates'));
        } catch (\Exception $e) {
            Log::error('Error loading create branch form', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
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
                'address' => 'nullable|string|max:1000',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'is_active' => 'boolean',
                'contact_profiles' => 'required|array|min:1',
                'contact_profiles.*.type' => 'required|in:phone,cell,whatsapp,email',
                'contact_profiles.*.value' => 'required|string|max:255',
                'contact_profiles.*.is_primary' => 'nullable|boolean',
                'neighbours' => 'required|array|min:1',
                'neighbours.*' => 'exists:neighbours,id',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            DB::beginTransaction();

            $branch = Branch::create([
                'name' => $validated['name'],
                'market_id' => $validated['market_id'],
                'address' => $validated['address'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'is_active' => $request->boolean('is_active', true),
            ]);

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

            // Attach neighbours
            $branch->neighbours()->attach($validated['neighbours']);
            Log::info('Neighbours attached', ['neighbours' => $validated['neighbours']]);

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch created successfully.');
        } catch (ValidationException $e) {
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
        try {
            $branch->load(['contactProfiles', 'neighbours']);
            $markets = Market::orderBy('name')->get();
            $emirates = Emirate::orderBy('name')->get();

            return view('admin.branch.edit', compact('branch', 'markets', 'emirates'));
        } catch (\Exception $e) {
            Log::error('Error loading edit branch form', [
                'branch_id' => $branch->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Branch $branch)
    {
        try {
            Log::info('Branch update request received', [
                'branch_id' => $branch->id,
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'market_id' => 'required|exists:markets,id',
                'address' => 'nullable|string|max:1000',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'is_active' => 'boolean',
                'contact_profiles' => 'required|array|min:1',
                'contact_profiles.*.type' => 'required|in:phone,cell,whatsapp,email',
                'contact_profiles.*.value' => 'required|string|max:255',
                'contact_profiles.*.is_primary' => 'nullable|boolean',
                'neighbours' => 'required|array|min:1',
                'neighbours.*' => 'exists:neighbours,id',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            DB::beginTransaction();

            // Update branch details
            $branch->update([
                'name' => $validated['name'],
                'market_id' => $validated['market_id'],
                'address' => $validated['address'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            Log::info('Branch updated', ['branch_id' => $branch->id]);

            // Delete existing contact profiles
            $oldProfiles = $branch->contactProfiles()->get();
            Log::info('Deleting old contact profiles', ['count' => $oldProfiles->count()]);
            $branch->contactProfiles()->delete();

            // Create new contact profiles
            foreach ($validated['contact_profiles'] as $index => $profile) {
                $isPrimary = isset($profile['is_primary']) && $profile['is_primary'] == '1';
                Log::info('Creating contact profile', [
                    'index' => $index,
                    'type' => $profile['type'],
                    'value' => $profile['value'],
                    'is_primary' => $isPrimary
                ]);

                $contactProfile = $branch->contactProfiles()->create([
                    'type' => $profile['type'],
                    'value' => $profile['value'],
                    'is_primary' => $isPrimary,
                ]);

                Log::info('Contact profile created', [
                    'contact_profile_id' => $contactProfile->id,
                    'branch_id' => $branch->id
                ]);
            }

            // Sync neighbours
            $branch->neighbours()->sync($validated['neighbours']);
            Log::info('Neighbours synced', ['neighbours' => $validated['neighbours']]);

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'branch_id' => $branch->id
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Branch update failed', [
                'branch_id' => $branch->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Failed to update branch: ' . $e->getMessage());
        }
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
} 