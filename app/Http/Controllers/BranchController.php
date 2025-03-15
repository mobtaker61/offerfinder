<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Market;
use App\Models\Emirate;
use App\Models\Offer;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request) {
        $query = Branch::query();

        if ($request->has('market_id')) {
            $query->where('market_id', $request->market_id);
        }

        $branches = $query->paginate(10);

        return view('admin.branch.index', compact('branches'));
    }

    public function create()
    {
        $markets = Market::all();
        $emirates = Emirate::all();
        return view('admin.branch.create', compact('markets', 'emirates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'market_id' => 'required|exists:markets,id',
            'emirate_id' => 'required|exists:emirates,id',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'working_hours' => 'nullable|string|max:255',
            'customer_service' => 'nullable|string|max:255',
        ]);

        Branch::create($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch)
    {
        $markets = Market::all();
        $emirates = Emirate::all();
        return view('admin.branch.edit', compact('branch', 'markets', 'emirates'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'market_id' => 'required|exists:markets,id',
            'emirate_id' => 'required|exists:emirates,id',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'working_hours' => 'nullable|string|max:255',
            'customer_service' => 'nullable|string|max:255',
        ]);

        $branch->update($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }

    public function getBranchesByMarketAndEmirate(Request $request)
    {
        $marketId = $request->query('market_id');
        $emirateId = $request->query('emirate_id');

        $branches = Branch::where('market_id', $marketId)
                          ->where('emirate_id', $emirateId)
                          ->get();

        $branchIds = $branches->pluck('id');
        $offers = Offer::whereHas('branches', function($query) use ($branchIds) {
            $query->whereIn('branch_id', $branchIds);
        })->get();

        return response()->json(['branches' => $branches, 'offers' => $offers]);
    }

    public function getOffersByBranch(Request $request)
    {
        $branchId = $request->query('branch_id');

        $offers = Offer::whereHas('branches', function($query) use ($branchId) {
            $query->where('branch_id', $branchId);
        })->get();

        return response()->json(['offers' => $offers]);
    }

    public function getBranchesByMarket(Request $request)
    {
        $branches = Branch::where('market_id', $request->market_id)->get();
        return response()->json(['branches' => $branches]);
    }
}
