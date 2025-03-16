<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    /**
     * Display a listing of the offers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $offers = Offer::with(['branches.market', 'images'])->get();
        return response()->json(['offers' => $offers], 200);
    }

    /**
     * Store a newly created offer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id',
            'is_vip' => 'sometimes|boolean',
            'images.*' => 'sometimes|image|max:2048',
        ]);

        // Create offer
        $offer = Offer::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_vip' => $request->input('is_vip', false),
        ]);
        
        // Attach branches
        $offer->branches()->attach($validated['branch_ids']);
        
        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('offers', 'public');
                OfferImage::create([
                    'offer_id' => $offer->id,
                    'image_path' => $path
                ]);
            }
        }

        return response()->json([
            'message' => 'Offer created successfully',
            'offer' => $offer->load('images', 'branches.market')
        ], 201);
    }

    /**
     * Display the specified offer.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Offer $offer)
    {
        $offer->load('branches.market', 'images');
        return response()->json(['offer' => $offer], 200);
    }

    /**
     * Update the specified offer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'branch_ids' => 'sometimes|required|array',
            'branch_ids.*' => 'exists:branches,id',
            'is_vip' => 'sometimes|boolean',
            'images.*' => 'sometimes|image|max:2048',
        ]);

        // Update offer attributes
        $offer->update([
            'title' => $validated['title'] ?? $offer->title,
            'description' => $validated['description'] ?? $offer->description,
            'start_date' => $validated['start_date'] ?? $offer->start_date,
            'end_date' => $validated['end_date'] ?? $offer->end_date,
            'is_vip' => $request->has('is_vip') ? $request->is_vip : $offer->is_vip,
        ]);
        
        // Update branches if provided
        if ($request->has('branch_ids')) {
            $offer->branches()->sync($validated['branch_ids']);
        }
        
        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('offers', 'public');
                OfferImage::create([
                    'offer_id' => $offer->id,
                    'image_path' => $path
                ]);
            }
        }

        return response()->json([
            'message' => 'Offer updated successfully',
            'offer' => $offer->load('images', 'branches.market')
        ], 200);
    }

    /**
     * Remove the specified offer from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Offer $offer)
    {
        // Delete associated images
        foreach ($offer->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Detach all branches
        $offer->branches()->detach();

        $offer->delete();
        return response()->json(['message' => 'Offer deleted successfully'], 200);
    }

    /**
     * Filter offers based on criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $query = Offer::query()->with(['branches.market', 'images']);

        if ($request->has('branch_id')) {
            $query->whereHas('branches', function ($q) use ($request) {
                $q->where('branches.id', $request->branch_id);
            });
        }

        if ($request->has('market_id')) {
            $query->whereHas('branches.market', function ($q) use ($request) {
                $q->where('markets.id', $request->market_id);
            });
        }

        if ($request->has('emirate_id')) {
            $query->whereHas('branches.market', function ($q) use ($request) {
                $q->whereHas('emirate', function($q2) use ($request) {
                    $q2->where('emirates.id', $request->emirate_id);
                });
            });
        }

        if ($request->has('vip') && $request->vip) {
            $query->where('is_vip', true);
        }

        $offers = $query->get();
        return response()->json(['offers' => $offers], 200);
    }

    /**
     * Toggle VIP status of an offer.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleVip(Offer $offer)
    {
        $offer->is_vip = !$offer->is_vip;
        $offer->save();

        return response()->json([
            'message' => 'Offer VIP status updated',
            'is_vip' => $offer->is_vip
        ], 200);
    }

    /**
     * Get offer card details
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function card($id)
    {
        $offer = Offer::with(['branches.market', 'images'])->findOrFail($id);
        return response()->json(['offer' => $offer], 200);
    }
}
