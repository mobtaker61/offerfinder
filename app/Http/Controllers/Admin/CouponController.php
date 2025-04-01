<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Market;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the coupons.
     */
    public function index()
    {
        $coupons = Coupon::with('couponable')
            ->latest()
            ->paginate(10);

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        $markets = Market::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        return view('admin.coupons.create', compact('markets', 'branches'));
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_unlimited' => 'boolean',
            'usage_limit' => 'nullable|required_if:is_unlimited,false|integer|min:1',
            'is_active' => 'boolean',
            'couponable_type' => 'required|string|in:App\Models\Market,App\Models\Branch',
            'couponable_id' => 'required|integer'
        ]);

        $coupon = new Coupon($validated);

        if ($request->hasFile('image')) {
            $coupon->image = $request->file('image')->store('coupons', 'public');
        }

        $coupon->save();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon)
    {
        $markets = Market::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        return view('admin.coupons.edit', compact('coupon', 'markets', 'branches'));
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_unlimited' => 'boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'couponable_type' => 'required|in:App\Models\Market,App\Models\Branch',
            'couponable_id' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($coupon->image) {
                Storage::disk('public')->delete($coupon->image);
            }
            $path = $request->file('image')->store('coupons', 'public');
            $validated['image'] = $path;
        }

        $coupon->update($validated);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(Coupon $coupon)
    {
        if ($coupon->image) {
            Storage::disk('public')->delete($coupon->image);
        }
        
        $coupon->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }

    /**
     * Toggle the active status of the coupon.
     */
    public function toggleActive(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon status updated successfully.');
    }
} 