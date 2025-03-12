<?php

namespace App\Http\Controllers;

use App\Models\OfferImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OfferImage $offerImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfferImage $offerImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfferImage $offerImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfferImage $offerImage)
    {
        Storage::delete('public/' . $offerImage->image);
        $offerImage->delete();
        return back()->with('success', 'Image deleted successfully.');
    }
}
