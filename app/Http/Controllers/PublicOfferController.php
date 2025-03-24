<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\Emirate;
use Illuminate\Http\Request;

class PublicOfferController extends Controller
{
    public function homepage(Request $request)
    {
        $markets = Market::all();
        $categories = OfferCategory::with('children')->mainCategories()->get();
        $emirates = Emirate::all();
    
        $query = Offer::where('end_date', '>=', now())->orderBy('start_date', 'desc');
    
        if ($request->has('market_id') && $request->market_id != 'all') {
            $query->where('market_id', $request->market_id);
        }

        if ($request->has('category_id') && $request->category_id != 'all') {
            $category = OfferCategory::find($request->category_id);
            if ($category) {
                if ($category->parent_id) {
                    $query->where('category_id', $category->id);
                } else {
                    $categoryIds = $category->children->pluck('id')->push($category->id);
                    $query->whereIn('category_id', $categoryIds);
                }
            }
        }
    
        $offers = $query->paginate(6);
    
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.offers', compact('offers'))->render()
            ]);
        }
    
        return view('front.welcome', compact('offers', 'markets', 'categories', 'emirates'));
    }
}
