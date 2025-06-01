<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Emirate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MarketController extends Controller
{
    /**
     * Display a listing of the markets.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $markets = Market::with('emirate')->get();
        return response()->json(['markets' => $markets], 200);
    }

    /**
     * Store a newly created market in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'emirate_id' => 'required|exists:emirates,id',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('markets', 'public');
            $validated['logo'] = $path;
        }

        $market = Market::create($validated);
        return response()->json(['message' => 'Market created successfully', 'market' => $market], 201);
    }

    /**
     * Display the specified market.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Market $market)
    {
        $market->load('emirate', 'branches');
        return response()->json(['market' => $market], 200);
    }

    /**
     * Update the specified market in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Market $market)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'emirate_id' => 'sometimes|required|exists:emirates,id',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('markets', 'public');
            $validated['logo'] = $path;
        }

        $market->update($validated);
        return response()->json(['message' => 'Market updated successfully', 'market' => $market], 200);
    }

    /**
     * Remove the specified market from storage.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Market $market)
    {
        $market->delete();
        return response()->json(['message' => 'Market deleted successfully'], 200);
    }

    /**
     * Get markets by emirate
     *
     * @param  \App\Models\Emirate  $emirate
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMarketsByEmirate(Emirate $emirate)
    {
        // Get markets that have at least one branch in the specified emirate
        $markets = Market::whereHas('branches', function($query) use ($emirate) {
            $query->where('emirate_id', $emirate->id);
        })->get();
        
        return response()->json(['markets' => $markets], 200);
    }

    /**
     * Display the specified market by id or slug.
     *
     * @param  string  $marketKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByIdOrSlug($marketKey)
    {
        $market = null;
        if (is_numeric($marketKey)) {
            $market = Market::with(['emirate', 'branches:id,market_id'])->where('id', $marketKey)->first();
        } else {
            $market = Market::with(['emirate', 'branches:id,market_id'])->where('slug', $marketKey)->first();
        }
        if (!$market) {
            return response()->json(['message' => 'Market not found'], 404);
        }

        // فقط id شعبه‌ها را جمع‌آوری کن
        $branchIds = $market->branches->pluck('id')->unique()->values();

        // آفرهای غیرتکراری همه شعبه‌ها (id, start_date, end_date)
        $offerQuery = \App\Models\Offer::select('offers.id', 'offers.start_date', 'offers.end_date')
            ->join('offer_branch', 'offers.id', '=', 'offer_branch.offer_id')
            ->whereIn('offer_branch.branch_id', $branchIds)
            ->distinct();
        $offers = $offerQuery->get()->map(function($offer) {
            return [
                'id' => $offer->id,
                'start_date' => $offer->start_date,
                'end_date' => $offer->end_date,
            ];
        })->values();

        // اطلاعات مارکت به صورت کامل (با روابط)
        $marketArr = $market->toArray();
        $marketArr['offers'] = $offers;
        return response()->json([
            'market' => $marketArr,
        ], 200);
    }
}
