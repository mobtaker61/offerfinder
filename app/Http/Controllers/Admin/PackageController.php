<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureType;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::orderBy('name')->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $featureTypes = FeatureType::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('admin.packages.create', compact('featureTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
            'feature_types' => 'required|array',
            'feature_types.*' => 'exists:feature_types,id',
        ]);

        $package = Package::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        // Attach selected features to the package
        $package->featureTypes()->attach($validated['feature_types']);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        $package->load('featureTypes');
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $featureTypes = FeatureType::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        $package->load('featureTypes');
        
        return view('admin.packages.edit', compact('package', 'featureTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
            'feature_types' => 'required|array',
            'feature_types.*' => 'exists:feature_types,id',
        ]);

        $package->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        // Sync selected features
        $package->featureTypes()->sync($validated['feature_types']);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        // Check if the package is used in any plan
        if ($package->plans()->count() > 0) {
            return redirect()->route('admin.packages.index')
                ->with('error', 'Cannot delete package as it is used in one or more plans.');
        }

        // Detach all feature types first
        $package->featureTypes()->detach();
        
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }
}
