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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Emirate::create($request->all());

        return redirect()->route('emirates.index')->with('success', 'Emirate created successfully.');
    }

    public function edit(Emirate $emirate)
    {
        return view('admin.emirates.edit', compact('emirate'));
    }

    public function update(Request $request, Emirate $emirate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $emirate->update($request->all());

        return redirect()->route('emirates.index')->with('success', 'Emirate updated successfully.');
    }

    public function destroy(Emirate $emirate)
    {
        $emirate->delete();

        return redirect()->route('emirates.index')->with('success', 'Emirate deleted successfully.');
    }
}
