<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Market;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BranchController extends Controller
{
    /**
     * Display a listing of branches.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $branches = Branch::with([
            'market.emirate',
            'district',
            'neighbours',
            'contactProfiles',
            'offers'
        ])->get();
        return response()->json(['branches' => $branches], 200);
    }

    /**
     * Store a newly created branch in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'market_id' => 'required|exists:markets,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'working_hours' => 'nullable|string',
            'customer_service' => 'nullable|string',
            'emirate_id' => 'nullable|exists:emirates,id',
        ]);

        $branch = Branch::create($validated);
        return response()->json(['message' => 'Branch created successfully', 'branch' => $branch], 201);
    }

    /**
     * Display the specified branch.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($key)
    {
        $branch = \App\Models\Branch::where('id', $key)->orWhere('slug', $key)->firstOrFail();
        $branch->load([
            'market.emirate',
            'district',
            'neighbours',
            'contactProfiles',
            'offers'
        ]);
        return response()->json(['branch' => $branch], 200);
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'market_id' => 'sometimes|required|exists:markets,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'working_hours' => 'nullable|string',
            'customer_service' => 'nullable|string',
            'emirate_id' => 'nullable|exists:emirates,id',
        ]);

        $branch->update($validated);
        return response()->json(['message' => 'Branch updated successfully', 'branch' => $branch], 200);
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Branch $branch)
    {
        // Detach all offers
        $branch->offers()->detach();
        
        $branch->delete();
        return response()->json(['message' => 'Branch deleted successfully'], 200);
    }

    /**
     * Get branches by market.
     *
     * @param  string|int  $marketKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBranchesByMarket($marketKey)
    {
        $market = Market::where('id', $marketKey)
            ->orWhere('slug', $marketKey)
            ->firstOrFail();

        $branches = Branch::with([
            'contactProfiles',
        ])->where('market_id', $market->id)->get();

        return response()->json(['branches' => $branches], 200);
    }

    /**
     * Get branches by market and emirate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBranchesByMarketAndEmirate(Request $request)
    {
        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'emirate_id' => 'required|exists:emirates,id'
        ]);

        $branches = Branch::where('market_id', $request->market_id)
                          ->where('emirate_id', $request->emirate_id)
                          ->get();

        return response()->json(['branches' => $branches], 200);
    }

    /**
     * Get offers by branch.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffersByBranch(Branch $branch)
    {
        $offers = $branch->offers()->with('images')->get();
            
        return response()->json(['offers' => $offers], 200);
    }
}
