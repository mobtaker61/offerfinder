<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferProductController extends Controller
{
    /**
     * Get all products for a given offer.
     * @param  int  $offerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($offerId)
    {
        $offer = Offer::with(['offerProducts.product', 'offerProducts.offerImage'])->findOrFail($offerId);
        $products = $offer->offerProducts->map(function ($offerProduct) {
            return [
                'id' => $offerProduct->id,
                'product_id' => $offerProduct->product_id,
                'product_name' => $offerProduct->product?->name,
                'product_image' => $offerProduct->product?->image,
                'variant' => $offerProduct->variant,
                'unit' => $offerProduct->unit,
                'quantity' => $offerProduct->quantity,
                'price' => $offerProduct->price,
                'offer_image_id' => $offerProduct->offer_image_id,
                'offer_image' => $offerProduct->offerImage?->image,
                'extracted_data' => $offerProduct->extracted_data,
            ];
        });
        return response()->json(['products' => $products], 200);
    }
} 