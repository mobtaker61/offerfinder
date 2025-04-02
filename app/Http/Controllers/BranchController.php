<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Offer;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function getBranchesByMarket(Request $request)
    {
        $branches = Branch::where('market_id', $request->market_id)->get();
        return response()->json(['branches' => $branches]);
    }

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

    public function show(Branch $branch)
    {
        // Increment view count
        $branch->incrementViewCount();

        // Get active offers
        $activeOffers = $branch->offers()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        // Get upcoming offers
        $upcomingOffers = $branch->offers()
            ->where('start_date', '>', now())
            ->get();

        // Get finished offers
        $finishedOffers = $branch->offers()
            ->where('end_date', '<', now())
            ->latest()
            ->take(6)
            ->get();

        // Get active coupons count from branch
        $branchActiveCoupons = $branch->coupons()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();

        // Get active coupons count from market
        $marketActiveCoupons = $branch->market->coupons()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();

        // Prepare stats
        $stats = [
            'active_offers' => $activeOffers->count(),
            'upcoming_offers' => $upcomingOffers->count(),
            'finished_offers' => $finishedOffers->count(),
            'active_coupons' => $branchActiveCoupons + $marketActiveCoupons
        ];

        return view('front.branch.show', compact(
            'branch',
            'activeOffers',
            'upcomingOffers',
            'finishedOffers',
            'stats',
            'branchActiveCoupons',
            'marketActiveCoupons'
        ));
    }
} 