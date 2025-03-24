<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emirate;
use App\Models\Market;
use App\Models\Branch;
use App\Models\Offer;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'total_offers' => Offer::count(),
            'total_views' => Offer::sum('view_count') + Branch::sum('view_count') + Market::sum('view_count'),
            'total_markets' => Market::count(),
            'total_branches' => Branch::count(),
        ];

        // Get additional statistics
        $additionalStats = [
            'active_offers' => Offer::active()->count(),
            'active_markets' => Market::where('is_active', true)->count(),
            'active_branches' => Branch::where('is_active', true)->count(),
        ];

        // Get visit statistics for the chart (last 7 days)
        $visitStats = collect(range(6, 0))->map(function ($day) {
            $date = now()->subDays($day);
            $dateStr = $date->format('Y-m-d');
            
            // Get views for each content type
            $offerViews = Offer::whereDate('created_at', '<=', $dateStr)
                ->get()
                ->sum(function ($offer) use ($dateStr) {
                    $cacheKey = "daily_views_offers_{$offer->id}_{$dateStr}";
                    return Cache::get($cacheKey, 0);
                });
                
            $branchViews = Branch::whereDate('created_at', '<=', $dateStr)
                ->get()
                ->sum(function ($branch) use ($dateStr) {
                    $cacheKey = "daily_views_branches_{$branch->id}_{$dateStr}";
                    return Cache::get($cacheKey, 0);
                });
                
            $marketViews = Market::whereDate('created_at', '<=', $dateStr)
                ->get()
                ->sum(function ($market) use ($dateStr) {
                    $cacheKey = "daily_views_markets_{$market->id}_{$dateStr}";
                    return Cache::get($cacheKey, 0);
                });
            
            return [
                'date' => $date->format('M d'),
                'views' => $offerViews + $branchViews + $marketViews
            ];
        });

        // Get top viewed offers
        $topViewedOffers = Offer::orderBy('view_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($offer) {
                return [
                    'id' => $offer->id,
                    'title' => $offer->title,
                    'views' => $offer->view_count,
                    'created_at' => $offer->created_at->format('M d, Y'),
                ];
            });

        // Get latest offers with their markets
        $latestOffers = Offer::with(['branches.market'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($offer) {
                return [
                    'id' => $offer->id,
                    'title' => $offer->title,
                    'market' => $offer->branches->pluck('market.name')->implode(', '),
                    'status' => $offer->is_active,
                    'created_at' => $offer->created_at->format('M d, Y'),
                ];
            });

        // Get latest blog posts
        $latestBlogPosts = Post::with('author')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'author' => $post->author ? $post->author->name : 'Unknown Author',
                    'status' => $post->is_active,
                    'created_at' => $post->created_at->format('M d, Y'),
                ];
            });

        // Get latest branches
        $latestBranches = Branch::with(['market.emirate', 'neighbours'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($branch) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->name,
                    'market' => optional($branch->market)->name ?? 'Unknown Market',
                    'neighbours' => $branch->neighbours->pluck('name'),
                    'status' => $branch->is_active,
                    'created_at' => $branch->created_at->format('M d, Y'),
                ];
            });

        // Get latest users
        $latestUsers = User::latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->is_active,
                    'created_at' => $user->created_at->format('M d, Y'),
                ];
            });

        return view('admin.dashboard', compact(
            'stats',
            'latestOffers',
            'latestBlogPosts',
            'latestBranches',
            'latestUsers',
            'additionalStats',
            'visitStats',
            'topViewedOffers'
        ));
    }
} 