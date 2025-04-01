<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Branch;
use App\Models\Offer;
use App\Models\Emirate;
use App\Models\Post;
use App\Models\OfferCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $emirateId = $request->query('emirate_id');
        $marketId = $request->query('market_id');
        $branchId = $request->query('branch_id');
        $categoryId = $request->query('category_id');

        // Get active offers (current date is between start_date and end_date)
        $offers = Offer::with(['branches.market', 'images', 'category'])
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->when($emirateId && $emirateId !== 'all', function ($query) use ($emirateId) {
                return $query->whereHas('branches', function ($query) use ($emirateId) {
                    $query->where('emirate_id', $emirateId);
                });
            })
            ->when($marketId && $marketId !== 'all', function ($query) use ($marketId) {
                return $query->whereHas('branches', function ($query) use ($marketId) {
                    $query->where('market_id', $marketId);
                });
            })
            ->when($branchId && $branchId !== 'all', function ($query) use ($branchId) {
                return $query->whereHas('branches', function ($query) use ($branchId) {
                    $query->where('id', $branchId);
                });
            })
            ->when($categoryId && $categoryId !== 'all', function ($query) use ($categoryId) {
                $category = OfferCategory::find($categoryId);
                if ($category) {
                    if ($category->parent_id) {
                        $query->where('category_id', $category->id);
                    } else {
                        $categoryIds = $category->children->pluck('id')->push($category->id);
                        $query->whereIn('category_id', $categoryIds);
                    }
                }
            })
            ->take(29)
            ->get();

        // Get VIP offers that are currently active
        $vipOffers = Offer::where('vip', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->inRandomOrder()
            ->take(3)
            ->get();

        $emirates = Emirate::all();
        $markets = Market::all();
        $branches = Branch::all();
        $categories = OfferCategory::with('children')->mainCategories()->get();

        // Get upcoming offers (start_date is in the future)
        $upcomingOffers = Offer::where('start_date', '>', now())
            ->orderBy('start_date')
            ->take(6)
            ->get();
                              
        $latestPosts = Post::latest()
            ->take(3)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'offers' => $offers,
                'markets' => $markets,
                'branches' => $branches,
            ]);
        }

        return view('front.welcome', compact('offers', 'markets', 'branches', 'emirates', 'vipOffers', 'upcomingOffers', 'latestPosts', 'categories'));
    }

    public function list(Request $request)
    {
        $emirateId = $request->query('emirate_id');
        $marketId = $request->query('market_id');
        $branchId = $request->query('branch_id');
        $status = $request->query('status', 'all');
        $sort = $request->query('sort', 'asc');

        $offers = Offer::with(['branches.market', 'images'])
            ->when($emirateId && $emirateId !== 'all', function ($query) use ($emirateId) {
                return $query->whereHas('branches', function ($query) use ($emirateId) {
                    $query->where('emirate_id', $emirateId);
                });
            })
            ->when($marketId && $marketId !== 'all', function ($query) use ($marketId) {
                return $query->whereHas('branches', function ($query) use ($marketId) {
                    $query->where('market_id', $marketId);
                });
            })
            ->when($branchId && $branchId !== 'all', function ($query) use ($branchId) {
                return $query->whereHas('branches', function ($query) use ($branchId) {
                    $query->where('id', $branchId);
                });
            })
            ->when($status !== 'all', function ($query) use ($status) {
                if ($status === 'active') {
                    return $query->where('end_date', '>=', now());
                } elseif ($status === 'finished') {
                    return $query->where('end_date', '<', now());
                }
            })
            ->orderBy('start_date', $sort)
            ->paginate(10);

        $emirates = Emirate::all();
        $markets = Market::all();
        $branches = Branch::all();

        if ($request->ajax()) {
            return response()->json([
                'offers' => $offers,
                'markets' => $markets,
                'branches' => $branches,
            ]);
        }

        return view('front.offer.index', compact('offers', 'markets', 'branches', 'emirates'));
    }

    public function getBranchesByMarketAndEmirate(Request $request)
    {
        $emirateId = $request->query('emirate_id');
        $marketId = $request->query('market_id');

        $markets = Market::when($emirateId && $emirateId !== 'all', function ($query) use ($emirateId) {
            return $query->whereHas('branches', function ($query) use ($emirateId) {
                $query->where('emirate_id', $emirateId);
            });
        })->get();

        $branches = Branch::when($emirateId && $emirateId !== 'all', function ($query) use ($emirateId) {
            return $query->where('emirate_id', $emirateId);
        })->when($marketId && $marketId !== 'all', function ($query) use ($marketId) {
            return $query->where('market_id', $marketId);
        })->get();

        return response()->json([
            'markets' => $markets,
            'branches' => $branches,
        ]);
    }
}
