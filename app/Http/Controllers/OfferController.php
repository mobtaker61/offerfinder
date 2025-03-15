<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Offer;
use App\Models\Market;
use App\Models\OfferImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Emirate;
use Carbon\Carbon;

class OfferController extends Controller
{
    public function index(Request $request) {
        $query = Offer::query();

        if ($request->has('market_id')) {
            $query->whereHas('branches.market', function($query) use ($request) {
                $query->where('markets.id', $request->market_id);
            });
        }

        if ($request->has('branch_id')) {
            $query->whereHas('branches', function($query) use ($request) {
                $query->where('branches.id', $request->branch_id);
            });
        }

        $offers = $query->paginate(10);

        return view('admin.offer.index', compact('offers'));
    }

    public function create()
    {
        $markets = Market::all();
        $branches = Branch::all();
        return view('admin.offer.create', compact('markets', 'branches'));
    }

    public function edit(Offer $offer)
    {
        $markets = Market::all();
        $branches = Branch::all();
        return view('admin.offer.edit', compact('offer', 'markets', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:5120',
            'offer_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $offer = new Offer($request->except('branch_ids'));

        if ($request->hasFile('cover_image')) {
            $offer->cover_image = $request->file('cover_image')->store('cover_images', 'public');
        }

        if ($request->hasFile('pdf')) {
            $offer->pdf = $request->file('pdf')->store('pdfs', 'public');
        }

        $offer->save();

        // Attach branches to the offer
        $offer->branches()->attach($request->branch_ids);

        if ($request->hasFile('offer_images')) {
            foreach ($request->file('offer_images') as $image) {
                $path = $image->store('offer_images', 'public');
                $offer->images()->create(['image' => $path]);
            }
        }

        sendToTelegram("New offer created: ". json_encode($request->all()));

        return redirect()->route('offers.index')->with('success', 'Offer created successfully.');
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:5120',
            'offer_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $offer->update($request->except('branch_ids'));

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($offer->cover_image);
            $offer->cover_image = $request->file('cover_image')->store('cover_images', 'public');
        }

        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($offer->pdf);
            $offer->pdf = $request->file('pdf')->store('pdfs', 'public');
        }

        // Sync branches with the offer
        $offer->branches()->sync($request->branch_ids);

        if ($request->hasFile('offer_images')) {
            foreach ($request->file('offer_images') as $image) {
                $path = $image->store('offer_images', 'public');
                $offer->images()->create(['image' => $path]);
            }
        }

        return redirect()->route('offers.index')->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        Storage::disk('public')->delete($offer->cover_image);
        Storage::disk('public')->delete($offer->pdf);
        $offer->delete();

        return redirect()->route('offers.index')->with('success', 'Offer deleted successfully.');
    }

    public function show($id)
    {
        $offer = Offer::with('branches.market')->findOrFail($id);
        $market = $offer->branches->first()->market ?? null;
        return view('front.offer.show', compact('offer', 'market'));
    }

    public function card($id)
    {
        $offer = Offer::with('branches.market')->findOrFail($id);
        return view('components.offer-card', compact('offer'))->render();
    }

    public function list(Request $request)
    {
        $emirates = Emirate::all();
        $offers = Offer::paginate(21); // Use pagination

        return view('front.offer.index', compact('emirates', 'offers'));
    }

    public function filter(Request $request)
    {
        $query = Offer::query();

        if ($request->branch_id && $request->branch_id != 'all') {
            $query->whereHas('branches', function ($q) use ($request) {
                $q->where('branches.id', $request->branch_id);
            });
        } elseif ($request->market_id && $request->market_id != 'all') {
            $query->whereHas('branches', function ($q) use ($request) {
                $q->where('branches.market_id', $request->market_id);
                if ($request->emirate_id && $request->emirate_id != 'all') {
                    $q->where('branches.emirate_id', $request->emirate_id);
                }
            });
        } elseif ($request->emirate_id && $request->emirate_id != 'all') {
            $query->whereHas('branches', function ($q) use ($request) {
                $q->where('branches.emirate_id', $request->emirate_id);
            });
        }

        if ($request->status && $request->status != 'all') {
            if ($request->status == 'active') {
                $query->where('end_date', '>=', Carbon::today());
            } elseif ($request->status == 'finished') {
                $query->where('end_date', '<', Carbon::today());
            }
        }

        if ($request->sort) {
            $query->orderBy('end_date', $request->sort);
        }

        $offers = $query->paginate(10);

        return response()->json(['offers' => $offers]);
    }
}
