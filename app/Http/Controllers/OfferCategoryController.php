<?php

namespace App\Http\Controllers;

use App\Models\OfferCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = OfferCategory::orderBy('order')->get();
        return view('admin.offer-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.offer-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'active' => 'boolean'
        ]);

        OfferCategory::create($validated);

        return redirect()->route('admin.offer-categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfferCategory $offerCategory)
    {
        return view('admin.offer-categories.edit', compact('offerCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfferCategory $offerCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'active' => 'boolean'
        ]);

        $offerCategory->update($validated);

        return redirect()->route('admin.offer-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfferCategory $offerCategory)
    {
        $offerCategory->delete();

        return redirect()->route('admin.offer-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
