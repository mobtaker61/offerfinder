<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfferImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferImageController extends Controller
{
    /**
     * Display a listing of offer images.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = OfferImage::query();
        
        if ($request->has('offer_id')) {
            $query->where('offer_id', $request->offer_id);
        }
        
        $images = $query->get();
        return response()->json(['images' => $images], 200);
    }

    /**
     * Store a newly created offer image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('offers', 'public');
        
        $offerImage = OfferImage::create([
            'offer_id' => $request->offer_id,
            'image_path' => $path,
        ]);

        return response()->json([
            'message' => 'Image uploaded successfully', 
            'image' => $offerImage
        ], 201);
    }

    /**
     * Display the specified offer image.
     *
     * @param  \App\Models\OfferImage  $offerImage
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(OfferImage $offerImage)
    {
        return response()->json(['image' => $offerImage], 200);
    }

    /**
     * Update the specified offer image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfferImage  $offerImage
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, OfferImage $offerImage)
    {
        $request->validate([
            'offer_id' => 'sometimes|required|exists:offers,id',
            'image' => 'sometimes|required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($offerImage->image_path);
            
            // Upload new image
            $path = $request->file('image')->store('offers', 'public');
            $offerImage->image_path = $path;
        }

        if ($request->has('offer_id')) {
            $offerImage->offer_id = $request->offer_id;
        }

        $offerImage->save();

        return response()->json([
            'message' => 'Image updated successfully', 
            'image' => $offerImage
        ], 200);
    }

    /**
     * Remove the specified offer image from storage.
     *
     * @param  \App\Models\OfferImage  $offerImage
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(OfferImage $offerImage)
    {
        // Delete image from storage
        Storage::disk('public')->delete($offerImage->image_path);
        
        // Delete database record
        $offerImage->delete();

        return response()->json(['message' => 'Image deleted successfully'], 200);
    }
}
