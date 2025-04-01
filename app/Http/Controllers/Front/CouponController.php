<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Market;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        // Start with a basic query
        $query = Coupon::query()
            ->with(['couponable'])
            ->where('is_active', true);

        // Debug: Log the initial query
        Log::info('Initial Query: ' . $query->toSql());
        Log::info('Initial Bindings: ' . json_encode($query->getBindings()));

        // Add date conditions
        $now = now();
        $query->where('start_date', '<=', $now)
              ->where('end_date', '>=', $now);

        // Debug: Log after date conditions
        Log::info('After Date Query: ' . $query->toSql());
        Log::info('After Date Bindings: ' . json_encode($query->getBindings()));

        // Add usage limit conditions
        $query->where(function($q) {
            $q->where('is_unlimited', true)
              ->orWhereRaw('used_count < usage_limit');
        });

        // Debug: Log after usage conditions
        Log::info('After Usage Query: ' . $query->toSql());
        Log::info('After Usage Bindings: ' . json_encode($query->getBindings()));

        // Filter by market
        if ($request->has('market_id') && $request->market_id !== 'all') {
            $query->where(function($q) use ($request) {
                $q->where('couponable_type', Market::class)
                  ->where('couponable_id', $request->market_id)
                  ->orWhere(function($q) use ($request) {
                      $q->where('couponable_type', Branch::class)
                        ->whereIn('couponable_id', function($q) use ($request) {
                            $q->select('id')
                              ->from('branches')
                              ->where('market_id', $request->market_id);
                        });
                  });
            });
        }

        // Filter by branch
        if ($request->has('branch_id') && $request->branch_id !== 'all') {
            $query->where('couponable_type', Branch::class)
                  ->where('couponable_id', $request->branch_id);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'expiring':
                $query->orderBy('end_date', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Debug: Log final query
        Log::info('Final Query: ' . $query->toSql());
        Log::info('Final Bindings: ' . json_encode($query->getBindings()));

        // Get total count before pagination
        $totalCount = $query->count();
        Log::info('Total Coupons Found: ' . $totalCount);

        // Get page size from request or default to 12
        $perPage = $request->get('per_page', 12);
        $perPage = in_array($perPage, [12, 24, 48, 96]) ? $perPage : 12;

        $coupons = $query->paginate($perPage);
        $markets = Market::all();
        
        // Get branches based on selected market
        $branches = collect();
        if ($request->has('market_id') && $request->market_id !== 'all') {
            $branches = Branch::where('market_id', $request->market_id)->get();
        }

        // Debug: Log the results
        Log::info('Coupons Count: ' . $coupons->count());
        Log::info('Markets Count: ' . $markets->count());
        Log::info('Branches Count: ' . $branches->count());

        return view('front.coupons.index', compact('coupons', 'markets', 'branches'));
    }

    public function getBranches(Request $request)
    {
        $marketId = $request->get('market_id');
        $branches = Branch::where('market_id', $marketId)->get();
        return response()->json($branches);
    }
} 