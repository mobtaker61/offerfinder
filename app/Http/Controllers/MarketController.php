<?php

namespace App\Http\Controllers;

use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MarketController extends Controller
{
    public function index(Request $request) {
        $query = Market::query();

        if ($request->has('emirate_id')) {
            $query->whereHas('branches', function($query) use ($request) {
                $query->where('emirate_id', $request->emirate_id);
            });
        }

        $markets = $query->get();

        return view('admin.market.index', compact('markets'));
    }

    public function create() {
        return view('admin.market.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'android_app_link' => 'nullable|url',
            'ios_app_link' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $market = new Market();
        $market->name = $request->name;
        $market->local_name = $request->local_name;
        $market->website = $request->website;
        $market->android_app_link = $request->android_app_link;
        $market->ios_app_link = $request->ios_app_link;
        $market->whatsapp = $request->whatsapp;
        $market->is_active = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $market->logo = $request->file('logo')->store('markets', 'public');
        }

        if ($request->hasFile('avatar')) {
            $market->avatar = $request->file('avatar')->store('markets', 'public');
        }

        $market->save();

        return redirect()->route('admin.markets.index')->with('success', 'Market created successfully.');
    }

    public function edit(Market $market) {
        return view('admin.market.edit', compact('market'));
    }

    public function update(Request $request, Market $market) {
        $request->validate([
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'android_app_link' => 'nullable|url',
            'ios_app_link' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($market->logo) {
                Storage::disk('public')->delete($market->logo);
            }
            $market->logo = $request->file('logo')->store('markets', 'public');
        }

        if ($request->hasFile('avatar')) {
            if ($market->avatar) {
                Storage::disk('public')->delete($market->avatar);
            }
            $market->avatar = $request->file('avatar')->store('markets', 'public');
        }

        $market->update([
            'name' => $request->name,
            'local_name' => $request->local_name,
            'website' => $request->website,
            'android_app_link' => $request->android_app_link,
            'ios_app_link' => $request->ios_app_link,
            'whatsapp' => $request->whatsapp,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.markets.index')->with('success', 'Market updated successfully.');
    }

    public function destroy(Market $market) {
        if ($market->logo) {
            Storage::disk('public')->delete($market->logo);
        }
        if ($market->avatar) {
            Storage::disk('public')->delete($market->avatar);
        }
        $market->delete();

        return redirect()->route('admin.markets.index')->with('success', 'Market deleted successfully.');
    }

    public function toggleStatus(Request $request, Market $market)
    {
        $market->is_active = $request->boolean('is_active');
        $market->save();

        return response()->json([
            'success' => true,
            'message' => 'Market status updated successfully.'
        ]);
    }

    public function getMarketsByEmirate(Request $request)
    {
        $markets = Market::whereHas('branches', function ($query) use ($request) {
            $query->where('emirate_id', $request->emirate_id);
        })->get();

        return response()->json(['markets' => $markets]);
    }
}
