<?php

namespace App\Http\Controllers;

use App\Models\OfferCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OfferCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainCategories = OfferCategory::mainCategories()
            ->with(['children' => function($query) {
                $query->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
        
        return view('admin.offer-categories.index', compact('mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = OfferCategory::mainCategories()
            ->with('children')
            ->orderBy('order')
            ->get();
        
        return view('admin.offer-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'active' => 'boolean',
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('offer_categories', 'id')->where(function ($query) {
                    // Ensure the selected parent is a main category or has no children
                    $query->whereNull('parent_id')
                          ->orWhereNotExists(function ($q) {
                              $q->from('offer_categories as children')
                                ->whereColumn('children.parent_id', 'offer_categories.id');
                          });
                }),
            ],
        ]);

        $category = OfferCategory::create($validated);

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
        $categories = OfferCategory::mainCategories()
            ->with('children')
            ->where('id', '!=', $offerCategory->id)
            ->whereNotIn('id', $offerCategory->children->pluck('id'))
            ->orderBy('order')
            ->get();
        
        return view('admin.offer-categories.edit', compact('offerCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfferCategory $offerCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'active' => 'boolean',
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('offer_categories', 'id')->where(function ($query) use ($offerCategory) {
                    // Prevent selecting itself or its children as parent
                    $query->whereNull('parent_id')
                          ->where('id', '!=', $offerCategory->id)
                          ->whereNotIn('id', $offerCategory->children->pluck('id'));
                }),
            ],
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
        // Check if category has children
        if ($offerCategory->hasChildren()) {
            return redirect()->route('admin.offer-categories.index')
                ->with('error', 'Cannot delete category with subcategories. Please delete subcategories first.');
        }

        // Move offers to parent category if exists
        if ($offerCategory->parent_id) {
            $offerCategory->offers()->update(['category_id' => $offerCategory->parent_id]);
        }

        $offerCategory->delete();

        return redirect()->route('admin.offer-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Get subcategories for a given parent category
     */
    public function getSubcategories(OfferCategory $category)
    {
        return response()->json([
            'subcategories' => $category->children()
                ->orderBy('order')
                ->select(['id', 'name', 'active'])
                ->get()
        ]);
    }

    /**
     * Reorder categories
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:offer_categories,id',
            'categories.*.order' => 'required|integer',
        ]);

        foreach ($validated['categories'] as $item) {
            OfferCategory::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Categories reordered successfully']);
    }
}
