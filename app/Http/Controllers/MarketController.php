<?php

namespace App\Http\Controllers;

use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index() {
        $markets = Market::all();
        return view('admin.market.index', compact('markets'));
    }

    public function create() {
        return view('admin.market.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'app_link' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:255',
        ]);

        $market = new Market();
        $market->name = $request->name;
        $market->website = $request->website;
        $market->app_link = $request->app_link;
        $market->whatsapp = $request->whatsapp;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $market->logo = $logoPath;
        }

        $market->save();

        return redirect()->route('markets.index')->with('success', 'Market created successfully.');
    }

    public function edit(Market $market) {
        return view('admin.market.edit', compact('market'));
    }

    public function update(Request $request, Market $market) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $market->logo = $logoPath;
        }

        $market->update($request->all());

        return redirect()->route('markets.index')->with('success', 'Market updated successfully.');
    }

    public function destroy(Market $market) {
        $market->delete();

        return redirect()->route('markets.index')->with('success', 'Market deleted successfully.');
    }

    public function getMarketsByEmirate(Request $request)
    {
        $markets = Market::whereHas('branches', function ($query) use ($request) {
            $query->where('emirate_id', $request->emirate_id);
        })->get();

        return response()->json(['markets' => $markets]);
    }
}
