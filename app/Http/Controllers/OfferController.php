<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Offer;
use App\Models\Market;
use App\Models\OfferImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use App\Models\Emirate;
use Carbon\Carbon;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::with(['market', 'branches', 'category']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('market', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedFields = ['title', 'start_date', 'end_date', 'created_at'];
        
        if (in_array($sortField, $allowedFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $offers = $query->paginate(10)->withQueryString();
        
        if ($request->ajax()) {
            return view('admin.offer.partials.offers-table', compact('offers'));
        }

        return view('admin.offer.index', compact('offers'));
    }

    public function create()
    {
        $markets = Market::all();
        return view('admin.offer.create', compact('markets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'pdf' => 'nullable|mimetypes:application/pdf|max:20480',
            'offer_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'cover_image.image' => 'The cover image must be a valid image file (JPEG, PNG, JPG, GIF).',
            'cover_image.mimes' => 'The cover image must be a file of type: jpeg, png, jpg, gif.',
            'cover_image.max' => 'The cover image may not be greater than 10MB.',
            'pdf.mimetypes' => 'The PDF file must be a valid PDF document.',
            'pdf.max' => 'The PDF file may not be greater than 20MB.',
            'offer_images.*.image' => 'All gallery images must be valid image files (JPEG, PNG, JPG, GIF).',
            'offer_images.*.mimes' => 'All gallery images must be files of type: jpeg, png, jpg, gif.',
            'offer_images.*.max' => 'Each gallery image may not be greater than 10MB.'
        ]);

        try {
            DB::beginTransaction();

            $offer = new Offer($request->except(['cover_image', 'pdf', 'offer_images', 'branch_ids']));

            if ($request->hasFile('cover_image')) {
                $cover = $request->file('cover_image');
                if ($cover->isValid()) {
                    $coverPath = $cover->store('offers/covers', 'public');
                    $offer->cover_image = $coverPath;
                }
            }

            if ($request->hasFile('pdf')) {
                $pdf = $request->file('pdf');
                if ($pdf->isValid()) {
                    $pdfPath = $pdf->store('offers/pdfs', 'public');
                    $offer->pdf = $pdfPath;
                }
            }

            $offer->save();

            // Attach branches
            $offer->branches()->attach($request->branch_ids);

            // Handle offer images
            if ($request->hasFile('offer_images')) {
                foreach ($request->file('offer_images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('offers/gallery', 'public');
                        $offer->images()->create(['image' => $path]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Offer created successfully',
                'redirect' => route('admin.offers.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating offer: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating offer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Offer $offer)
    {
        $markets = Market::all();
        $branches = Branch::where('market_id', $offer->market_id)->get();
        return view('admin.offer.edit', compact('offer', 'markets', 'branches'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'pdf' => 'nullable|mimetypes:application/pdf|max:20480',
            'offer_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        try {
            DB::beginTransaction();

            // Update basic offer information
            $offer->fill($request->except(['cover_image', 'pdf', 'offer_images', 'branch_ids']));

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $cover = $request->file('cover_image');
                if ($cover->isValid()) {
                    // Delete old cover image if it exists
                    if ($offer->cover_image && Storage::disk('public')->exists($offer->cover_image)) {
                        Storage::disk('public')->delete($offer->cover_image);
                    }
                    $coverPath = $cover->store('offers/covers', 'public');
                    $offer->cover_image = $coverPath;
                }
            }

            // Handle PDF upload
            if ($request->hasFile('pdf')) {
                $pdf = $request->file('pdf');
                if ($pdf->isValid()) {
                    // Delete old PDF if it exists
                    if ($offer->pdf && Storage::disk('public')->exists($offer->pdf)) {
                        Storage::disk('public')->delete($offer->pdf);
                    }
                    $pdfPath = $pdf->store('offers/pdfs', 'public');
                    $offer->pdf = $pdfPath;
                }
            }

            $offer->save();

            // Update branches
            $offer->branches()->sync($request->branch_ids);

            // Handle offer images
            if ($request->hasFile('offer_images')) {
                // Delete old gallery images if they exist
                foreach ($offer->images as $image) {
                    if ($image->image && Storage::disk('public')->exists($image->image)) {
                        Storage::disk('public')->delete($image->image);
                    }
                }
                $offer->images()->delete();

                // Upload new gallery images
                foreach ($request->file('offer_images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('offers/gallery', 'public');
                        $offer->images()->create(['image' => $path]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Offer updated successfully',
                'redirect' => route('admin.offers.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating offer: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating offer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Offer $offer)
    {
        try {
            DB::beginTransaction();
            
            if ($offer->cover_image) {
                Storage::disk('public')->delete($offer->cover_image);
            }
            if ($offer->pdf) {
                Storage::disk('public')->delete($offer->pdf);
            }
            
            foreach ($offer->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
            
            $offer->delete();
            
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Offer deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting offer: ' . $e->getMessage()], 500);
        }
    }

    public function toggleVip(Request $request, Offer $offer)
    {
        try {
            $offer->vip = $request->vip;
            $offer->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
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

    /**
     * Get offers by market with optional emirate filtering
     *
     * @param  \App\Models\Market  $market
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function getOffersByMarket(Market $market, Request $request)
    {
        $query = Offer::whereHas('branches', function($query) use ($market) {
            $query->where('market_id', $market->id);
        });
        
        // If emirate_id is provided, filter by the specific emirate
        if ($request->has('emirate_id')) {
            $emirate_id = $request->emirate_id;
            $query->whereHas('branches', function($query) use ($emirate_id) {
                $query->where('emirate_id', $emirate_id);
            });
        }
        
        $offers = $query->paginate(10);
        $emirates = Emirate::all();
        
        return view('front.offer.market', compact('offers', 'market', 'emirates'));
    }

    /**
     * Get offers by emirate
     *
     * @param  \App\Models\Emirate  $emirate
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function getOffersByEmirate(Emirate $emirate, Request $request)
    {
        $query = Offer::whereHas('branches', function($query) use ($emirate) {
            $query->where('emirate_id', $emirate->id);
        });
        
        $offers = $query->paginate(10);
        $markets = Market::whereHas('branches', function($query) use ($emirate) {
            $query->where('emirate_id', $emirate->id);
        })->get();
        
        return view('front.offer.emirate', compact('offers', 'emirate', 'markets'));
    }

    /**
     * Get offers by emirate and market
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function getOffersByEmirateAndMarket(Request $request)
    {
        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'emirate_id' => 'required|exists:emirates,id'
        ]);

        $query = Offer::whereHas('branches', function($query) use ($request) {
            $query->where('market_id', $request->market_id)
                  ->where('emirate_id', $request->emirate_id);
        });
        
        $offers = $query->paginate(10);
        $market = Market::findOrFail($request->market_id);
        $emirate = Emirate::findOrFail($request->emirate_id);
        
        return view('front.offer.emirate-market', compact('offers', 'market', 'emirate'));
    }

    public function getBranchesByMarket(Request $request)
    {
        $branches = Branch::where('market_id', $request->market_id)->get();
        return response()->json(['branches' => $branches]);
    }
}
