<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Emirate;
use App\Models\District;
use App\Models\Neighbour;
use App\Models\OfferCategory;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        // Get all filter options first (for sidebar)
        $emirates = Emirate::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        $neighbours = Neighbour::orderBy('name')->get();
        $categories = OfferCategory::orderBy('name')->get();

        // Build the query
        $query = Market::query()
            ->with([
                'branches.neighbours.district.emirate',
                'offers' => function($q) {
                    $q->active();
                }
            ]);

        // Apply filters
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('local_name', 'like', $search);
            });
        }

        if ($request->filled('emirate')) {
            $query->whereHas('branches.neighbours.district.emirate', function($q) use ($request) {
                $q->whereIn('emirates.id', (array)$request->emirate);
            });
        }

        if ($request->filled('district')) {
            $query->whereHas('branches.neighbours.district', function($q) use ($request) {
                $q->whereIn('districts.id', (array)$request->district);
            });
        }

        if ($request->filled('neighbour')) {
            $query->whereHas('branches.neighbours', function($q) use ($request) {
                $q->whereIn('neighbours.id', (array)$request->neighbour);
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('offers.category', function($q) use ($request) {
                $q->whereIn('offer_categories.id', (array)$request->category);
            });
        }

        // Apply sorting
        switch ($request->get('sort', 'name')) {
            case 'name-desc':
                $query->orderByDesc('name');
                break;
            case 'offers':
                $query->withCount(['offers' => function($q) {
                    $q->active();
                }])->orderByDesc('offers_count');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderBy('name');
        }

        // Get paginated results
        $markets = $query->paginate(12)->withQueryString();

        // Add counts to markets
        $markets->each(function($market) {
            $market->active_offers_count = $market->offers->count();
            $market->branches_count = $market->branches->count();
            $market->emirates_list = $market->branches
                ->map(function($branch) {
                    // Safely access the relationships
                    if ($branch->neighbours && $branch->neighbours->first()) {
                        $neighbour = $branch->neighbours->first();
                        if ($neighbour->district && $neighbour->district->emirate) {
                            return $neighbour->district->emirate->name;
                        }
                    }
                    return null;
                })
                ->filter() // Remove null values
                ->unique()
                ->implode(', ');
        });

        return view('front.market.index', compact(
            'markets',
            'emirates',
            'districts',
            'neighbours',
            'categories'
        ));
    }

    public function show(Market $market)
    {
        // Increment view count
        $market->incrementViewCount();
        
        $market->load([
            'branches.neighbours.district.emirate',
            'branches.market',
            'branches.contactProfiles',
            'offers' => function($q) {
                $q->active();
            }
        ]);

        // Get offers by status with pagination
        $activeOffers = $market->offers()->active()->paginate(6, ['*'], 'active_page');
        $upcomingOffers = $market->offers()->upcoming()->paginate(6, ['*'], 'upcoming_page');
        $finishedOffers = $market->offers()->finished()->paginate(6, ['*'], 'finished_page');

        // Get stats
        $stats = [
            'total_branches' => $market->branches->count(),
            'total_offers' => $market->offers->count(),
            'active_offers' => $activeOffers->total(),
            'upcoming_offers' => $upcomingOffers->total(),
            'finished_offers' => $finishedOffers->total(),
            'emirates_count' => $market->branches->pluck('emirate_id')->unique()->count()
        ];

        return view('front.market.show', compact(
            'market',
            'activeOffers',
            'upcomingOffers',
            'finishedOffers',
            'stats'
        ));
    }

    public function getOffersByStatus(Request $request, Market $market)
    {
        $status = $request->status ?? 'active';
        $offers = $market->offers();

        switch ($status) {
            case 'upcoming':
                $offers->upcoming();
                break;
            case 'finished':
                $offers->finished();
                break;
            default:
                $offers->active();
        }

        $offers = $offers->paginate(6);

        return response()->json([
            'html' => view('front.market._offers_grid', compact('offers'))->render(),
            'pagination' => view('front.market._pagination', compact('offers'))->render()
        ]);
    }
} 