<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureType;
use App\Models\Package;
use App\Models\Plan;
use App\Models\PlanFeatureValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::with('package')->orderBy('name')->paginate(10);
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages = Package::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('admin.plans.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'package_id' => 'required|exists:packages,id',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
            'feature_values' => 'required|array',
            'feature_values.*' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $plan = Plan::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'package_id' => $validated['package_id'],
                'monthly_price' => $validated['monthly_price'],
                'yearly_price' => $validated['yearly_price'],
                'is_active' => $validated['is_active'] ?? false,
            ]);

            // Get the package and its feature types
            $package = Package::with('featureTypes')->findOrFail($validated['package_id']);
            
            // Create feature values for each feature type in the package
            foreach ($package->featureTypes as $featureType) {
                if (isset($validated['feature_values'][$featureType->id])) {
                    PlanFeatureValue::create([
                        'plan_id' => $plan->id,
                        'feature_type_id' => $featureType->id,
                        'value' => $validated['feature_values'][$featureType->id],
                    ]);
                }
            }

            DB::commit();
            
            return redirect()->route('admin.plans.index')
                ->with('success', 'Plan created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create plan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        $plan->load(['package', 'featureValues.featureType']);
        return view('admin.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        $packages = Package::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        $plan->load(['package.featureTypes', 'featureValues']);
        
        // Create a map of feature values for easier access in the view
        $featureValues = $plan->featureValues->pluck('value', 'feature_type_id')->toArray();
        
        return view('admin.plans.edit', compact('plan', 'packages', 'featureValues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'package_id' => 'required|exists:packages,id',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
            'feature_values' => 'required|array',
            'feature_values.*' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $plan->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'package_id' => $validated['package_id'],
                'monthly_price' => $validated['monthly_price'],
                'yearly_price' => $validated['yearly_price'],
                'is_active' => $validated['is_active'] ?? false,
            ]);

            // If package has changed, delete existing feature values and create new ones
            if ($plan->isDirty('package_id')) {
                // Delete existing feature values
                $plan->featureValues()->delete();
                
                // Get the new package and its feature types
                $package = Package::with('featureTypes')->findOrFail($validated['package_id']);
                
                // Create feature values for each feature type in the package
                foreach ($package->featureTypes as $featureType) {
                    if (isset($validated['feature_values'][$featureType->id])) {
                        PlanFeatureValue::create([
                            'plan_id' => $plan->id,
                            'feature_type_id' => $featureType->id,
                            'value' => $validated['feature_values'][$featureType->id],
                        ]);
                    }
                }
            } else {
                // Update existing feature values
                $package = $plan->package;
                $package->load('featureTypes');
                
                foreach ($package->featureTypes as $featureType) {
                    if (isset($validated['feature_values'][$featureType->id])) {
                        PlanFeatureValue::updateOrCreate(
                            [
                                'plan_id' => $plan->id,
                                'feature_type_id' => $featureType->id,
                            ],
                            [
                                'value' => $validated['feature_values'][$featureType->id],
                            ]
                        );
                    }
                }
            }

            DB::commit();
            
            return redirect()->route('admin.plans.index')
                ->with('success', 'Plan updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update plan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        // Check if the plan is assigned to any markets
        if ($plan->markets()->count() > 0) {
            return redirect()->route('admin.plans.index')
                ->with('error', 'Cannot delete plan as it is assigned to one or more markets.');
        }

        try {
            DB::beginTransaction();
            
            // Delete all feature values first
            $plan->featureValues()->delete();
            
            // Delete the plan
            $plan->delete();
            
            DB::commit();
            
            return redirect()->route('admin.plans.index')
                ->with('success', 'Plan deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.plans.index')
                ->with('error', 'Failed to delete plan: ' . $e->getMessage());
        }
    }
    
    /**
     * Get feature types for a package (for AJAX requests)
     */
    public function getPackageFeatures(Package $package)
    {
        $package->load('featureTypes');
        return response()->json($package->featureTypes);
    }
}
