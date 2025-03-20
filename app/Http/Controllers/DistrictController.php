<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Emirate;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::with('emirate')->latest()->paginate(10);
        return view('admin.districts.index', compact('districts'));
    }

    public function create()
    {
        $emirates = Emirate::all();
        return view('admin.districts.create', compact('emirates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'boundary_coordinates' => 'nullable|json',
            'description' => 'nullable|string',
            'emirate_id' => 'required|exists:emirates,id',
            'is_active' => 'boolean'
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active');

        // Handle boundary coordinates
        if (!empty($validated['boundary_coordinates'])) {
            $validated['boundary_coordinates'] = json_decode($validated['boundary_coordinates'], true);
        }

        District::create($validated);

        return redirect()->route('admin.districts.index')
            ->with('success', 'District created successfully.');
    }

    public function show(District $district)
    {
        return view('admin.districts.show', compact('district'));
    }

    public function edit(District $district)
    {
        $emirates = Emirate::all();
        return view('admin.districts.edit', compact('district', 'emirates'));
    }

    public function update(Request $request, District $district)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'boundary_coordinates' => 'nullable|json',
            'description' => 'nullable|string',
            'emirate_id' => 'required|exists:emirates,id',
            'is_active' => 'boolean'
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active');

        // Handle boundary coordinates
        if (!empty($validated['boundary_coordinates'])) {
            $validated['boundary_coordinates'] = json_decode($validated['boundary_coordinates'], true);
        }

        $district->update($validated);

        return redirect()->route('admin.districts.index')
            ->with('success', 'District updated successfully.');
    }

    public function destroy(District $district)
    {
        $district->delete();

        return redirect()->route('admin.districts.index')
            ->with('success', 'District deleted successfully.');
    }

    public function getDistrictsByEmirate(Emirate $emirate)
    {
        sendToTelegram('getDistrictsByEmirate' . json_encode($emirate));
        try {
            $districts = $emirate->districts()
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch districts'], 500);
        }
    }
} 