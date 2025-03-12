<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Offer;
use Illuminate\Http\Request;

class PublicOfferController extends Controller
{
    public function homepage(Request $request)
    {
        $markets = Market::all();
    
        $query = Offer::where('end_date', '>=', now())->orderBy('start_date', 'desc');
    
        if ($request->has('market_id') && $request->market_id != 'all') {
            $query->where('market_id', $request->market_id);
        }
    
        $offers = $query->paginate(6);
    
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.offers', compact('offers'))->render()
            ]);
        }
    
        return view('public.welcome', compact('offers', 'markets'));
    }
}
