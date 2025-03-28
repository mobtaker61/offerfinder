<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeatureTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $featureTypes = FeatureType::orderBy('name')->paginate(10);
        return view('admin.feature-types.index', compact('featureTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.feature-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:feature_types',
            'description' => 'nullable|string',
            'value_type' => ['required', Rule::in(['integer', 'boolean', 'string'])],
            'is_active' => 'sometimes|boolean',
        ]);

        FeatureType::create($validated);

        return redirect()->route('admin.feature-types.index')
            ->with('success', 'Feature type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeatureType $featureType)
    {
        return view('admin.feature-types.show', compact('featureType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeatureType $featureType)
    {
        return view('admin.feature-types.edit', compact('featureType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeatureType $featureType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => ['required', 'string', 'max:255', Rule::unique('feature_types')->ignore($featureType)],
            'description' => 'nullable|string',
            'value_type' => ['required', Rule::in(['integer', 'boolean', 'string'])],
            'is_active' => 'sometimes|boolean',
        ]);

        $featureType->update($validated);

        return redirect()->route('admin.feature-types.index')
            ->with('success', 'Feature type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeatureType $featureType)
    {
        // Check if the feature type is used in any package
        if ($featureType->packages()->count() > 0) {
            return redirect()->route('admin.feature-types.index')
                ->with('error', 'Cannot delete feature type as it is used in one or more packages.');
        }

        $featureType->delete();

        return redirect()->route('admin.feature-types.index')
            ->with('success', 'Feature type deleted successfully.');
    }
}
