<?php

namespace App\Http\Controllers;

use App\Models\Emirate;
use Illuminate\Http\Request;

class EmirateController extends Controller
{
    public function index()
    {
        $emirates = Emirate::all();
        return view('admin.emirates.index', compact('emirates'));
    }

    public function create()
    {
        return view('admin.emirates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'boundary_coordinates' => 'nullable|json',
            'is_active' => 'boolean'
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active');

        // Handle boundary coordinates
        if (!empty($validated['boundary_coordinates'])) {
            $validated['boundary_coordinates'] = json_decode($validated['boundary_coordinates'], true);
        }

        Emirate::create($validated);

        return redirect()->route('admin.emirates.index')
            ->with('success', 'Emirate created successfully.');
    }

    public function edit(Emirate $emirate)
    {
        return view('admin.emirates.edit', compact('emirate'));
    }

    public function update(Request $request, Emirate $emirate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'boundary_coordinates' => 'nullable|json',
            'is_active' => 'boolean'
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active');

        // Handle boundary coordinates
        if (!empty($validated['boundary_coordinates'])) {
            $validated['boundary_coordinates'] = json_decode($validated['boundary_coordinates'], true);
        }

        $emirate->update($validated);

        return redirect()->route('admin.emirates.index')
            ->with('success', 'Emirate updated successfully.');
    }

    public function destroy(Emirate $emirate)
    {
        $emirate->delete();

        return redirect()->route('admin.emirates.index')
            ->with('success', 'Emirate deleted successfully.');
    }
}
