<?php

namespace App\Http\Controllers;

use App\Models\Neighbour;
use App\Models\District;
use App\Models\Emirate;
use Illuminate\Http\Request;

class NeighbourController extends Controller
{
    public function index(Request $request)
    {
        $query = Neighbour::with(['district.emirate'])->latest();
        
        // Filter by district_id if provided
        if ($request->has('district_id')) {
            $query->where('district_id', $request->district_id);
        }
        
        // Get per_page from request with default value of 10
        $perPage = $request->get('per_page', 10);
        
        $neighbours = $query->paginate($perPage);
        return view('admin.neighbours.index', compact('neighbours'));
    }

    public function create()
    {
        $districts = District::with('emirate')->get();
        $emirates = Emirate::orderBy('name')->get();
        return view('admin.neighbours.create', compact('districts', 'emirates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'boundary_coordinates' => 'nullable|json',
            'info_link' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active');

        // Decode boundary coordinates if provided
        if (!empty($validated['boundary_coordinates'])) {
            $validated['boundary_coordinates'] = json_decode($validated['boundary_coordinates'], true);
        }

        $neighbour = Neighbour::create($validated);

        return redirect()->route('admin.neighbours.index')
            ->with('success', 'Neighbour created successfully.');
    }

    public function show(Neighbour $neighbour)
    {
        return view('admin.neighbours.show', compact('neighbour'));
    }

    public function edit(Neighbour $neighbour)
    {
        $districts = District::with('emirate')->get();
        $emirates = Emirate::orderBy('name')->get();
        return view('admin.neighbours.edit', compact('neighbour', 'districts', 'emirates'));
    }

    public function update(Request $request, Neighbour $neighbour)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'boundary_coordinates' => 'nullable|json',
            'info_link' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active');

        // Decode boundary coordinates if provided
        if (!empty($validated['boundary_coordinates'])) {
            $validated['boundary_coordinates'] = json_decode($validated['boundary_coordinates'], true);
        }

        $neighbour->update($validated);

        return redirect()->route('admin.neighbours.index')
            ->with('success', 'Neighbour updated successfully.');
    }

    public function destroy(Neighbour $neighbour)
    {
        $neighbour->delete();

        return redirect()->route('admin.neighbours.index')
            ->with('success', 'Neighbour deleted successfully.');
    }

    public function getNeighboursByDistrict(District $district)
    {
        try {
            $neighbours = $district->neighbours()
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
            return response()->json($neighbours);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch neighbours'], 500);
        }
    }
} 