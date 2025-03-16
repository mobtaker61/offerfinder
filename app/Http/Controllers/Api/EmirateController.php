<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emirate;
use Illuminate\Http\Request;

class EmirateController extends Controller
{
    /**
     * Display a listing of emirates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $emirates = Emirate::all();
        return response()->json(['emirates' => $emirates], 200);
    }

    /**
     * Store a newly created emirate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:emirates',
            'flag' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('flag')) {
            $path = $request->file('flag')->store('emirates', 'public');
            $validated['flag'] = $path;
        }

        $emirate = Emirate::create($validated);
        return response()->json(['message' => 'Emirate created successfully', 'emirate' => $emirate], 201);
    }

    /**
     * Display the specified emirate.
     *
     * @param  \App\Models\Emirate  $emirate
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Emirate $emirate)
    {
        $emirate->load('markets.branches');
        return response()->json(['emirate' => $emirate], 200);
    }

    /**
     * Update the specified emirate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Emirate  $emirate
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Emirate $emirate)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'nullable|string|max:10|unique:emirates,code,'.$emirate->id,
            'flag' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('flag')) {
            $path = $request->file('flag')->store('emirates', 'public');
            $validated['flag'] = $path;
        }

        $emirate->update($validated);
        return response()->json(['message' => 'Emirate updated successfully', 'emirate' => $emirate], 200);
    }

    /**
     * Remove the specified emirate from storage.
     *
     * @param  \App\Models\Emirate  $emirate
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Emirate $emirate)
    {
        $emirate->delete();
        return response()->json(['message' => 'Emirate deleted successfully'], 200);
    }
}
