<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Offer;
use App\Models\Market;
use App\Models\OfferImage;
use App\Models\Product;
use App\Models\OfferProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use App\Models\Emirate;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\OfferCategory;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function __construct(private AuditLogService $auditLog)
    {}

    public function index(Request $request)
    {
        $query = Offer::with(['market', 'branches', 'category.parent']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('market', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function($q) use ($search) {
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
        $categories = OfferCategory::with('children')->mainCategories()->get();
        return view('admin.offer.create', compact('markets', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id',
            'category_id' => 'required|exists:offer_categories,id',
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

            // Handle offer images and analyze them with ChatGPT
            if ($request->hasFile('offer_images')) {
                foreach ($request->file('offer_images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('offers/gallery', 'public');
                        $offerImage = $offer->images()->create(['image' => $path]);
                        
                        // Analyze image with ChatGPT
                        $this->analyzeImageWithChatGPT(Storage::disk('public')->path($path), $offer, $offerImage);
                    }
                }
            }

            DB::commit();

            // Log the change
            $this->auditLog->log(
                Auth::user(),
                'create',
                $offer,
                [],
                $offer->toArray(),
                $request
            );

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
        $categories = OfferCategory::with('children')->mainCategories()->get();
        return view('admin.offer.edit', compact('offer', 'markets', 'branches', 'categories'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id',
            'category_id' => 'required|exists:offer_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'pdf' => 'nullable|mimetypes:application/pdf|max:20480',
            'offer_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $oldValues = $offer->toArray();
        
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

            // Handle new offer images if any are uploaded
            if ($request->hasFile('offer_images')) {
                // Upload new gallery images and analyze them
                foreach ($request->file('offer_images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('offers/gallery', 'public');
                        $offerImage = $offer->images()->create(['image' => $path]);
                        
                        // Analyze image with ChatGPT
                        $this->analyzeImageWithChatGPT(Storage::disk('public')->path($path), $offer, $offerImage);
                    }
                }
            }

            DB::commit();

            // Log the change
            $this->auditLog->log(
                Auth::user(),
                'update',
                $offer,
                $oldValues,
                $offer->toArray(),
                $request
            );

            return response()->json(['success' => true,'message' => 'Offer updated successfully','redirect' => route('admin.offers.index')]);

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
                // Delete related offer_product records first
                OfferProduct::where('offer_image_id', $image->id)->delete();
                
                // Then delete the image file and record
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

    public function show(Offer $offer)
    {
        // Increment view count
        $offer->incrementViewCount();
        
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

    /**
     * Analyze image using ChatGPT API to extract product information
     *
     * @param string $imagePath Full path to the image file
     * @param Offer $offer The offer being processed
     * @param OfferImage $offerImage The offer image being processed
     * @return string Formatted product information
     */
    private function analyzeImageWithChatGPT($imagePath, Offer $offer = null, OfferImage $offerImage = null)
    {
        try {
            // Log the start of image analysis
            Log::info('Starting image analysis with ChatGPT for: ' . $imagePath);
            
            // Check if API key is set
            $apiKey = env('OPENAI_API_KEY');
            if (empty($apiKey)) {
                Log::error('OpenAI API key is not set in .env file');
                return '';
            }
            
            // Clean the API key - remove any whitespace or line breaks
            $apiKey = trim(preg_replace('/\s+/', '', $apiKey));
            Log::info('API Key length: ' . strlen($apiKey));
            
            // Test if the API key works with a simple text request first
            try {
                $testResponse = $this->testOpenAIAccess($apiKey);
                if (!$testResponse) {
                    Log::error('OpenAI API key validation failed');
                    return 'API access test failed. Please check your API key.';
                }
                
                Log::info('OpenAI API key is valid, proceeding with image analysis');
            } catch (\Exception $e) {
                Log::error('OpenAI API test failed: ' . $e->getMessage());
                return 'API test failed: ' . $e->getMessage();
            }
            
            // Encode image to base64
            $imageData = '';
            
            // Check if the path is a local file or URL
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                // It's a URL
                $imageContents = @file_get_contents($imagePath);
                if ($imageContents === false) {
                    // Try with cURL if file_get_contents fails
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $imagePath);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    $imageContents = curl_exec($ch);
                    curl_close($ch);
                    
                    if (empty($imageContents)) {
                        Log::error('Failed to download image from URL: ' . $imagePath);
                        return 'Failed to download image from URL';
                    }
                }
                $imageData = base64_encode($imageContents);
            } else {
                // It's a local file
                if (!file_exists($imagePath)) {
                    Log::error('Image file does not exist: ' . $imagePath);
                    
                    // Try to generate a public URL from storage path
                    $publicUrl = str_replace('/app/public/', '/storage/', $imagePath);
                    
                    if (file_exists(public_path($publicUrl))) {
                        $imageData = base64_encode(file_get_contents(public_path($publicUrl)));
                    } else {
                        return 'Image file not found';
                    }
                } else {
                    $imageData = base64_encode(file_get_contents($imagePath));
                }
            }
            
            if (empty($imageData)) {
                return 'Failed to encode image';
            }
            
            // Create ChatGPT API client
            $client = new Client();
            
            // Make API request to OpenAI
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o', // Updated to the current vision-capable model
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Please analyze this product image and extract the following information:

1. Product name
2. Variant (weight/size/type)
3. Quantity
4. Unit (kg, g, ml, pcs, etc.)
5. Price

IMPORTANT FORMATTING INSTRUCTIONS:
- ONLY return valid JSON without any extra text, explanation, or formatting
- DO NOT include backticks, code blocks, or markdown
- DO NOT include any text before or after the JSON
- Use the EXACT format specified below

For a SINGLE product, return a JSON object with this structure:
{
  "name": "Product Name",
  "variant": "Weight or Type",
  "quantity": Number,
  "unit": "Unit of measurement",
  "price": Number
}

If MULTIPLE products are visible (VERY IMPORTANT), return a JSON ARRAY of product objects:
[
  {
    "name": "Product 1 Name",
    "variant": "Weight or Type",
    "quantity": Number,
    "unit": "Unit of measurement",
    "price": Number
  },
  {
    "name": "Product 2 Name",
    "variant": "Weight or Type",
    "quantity": Number,
    "unit": "Unit of measurement",
    "price": Number
  }
]

If a field is missing or unknown, use null for that field.
Note: This is a critical task - ENSURE that your response is ONLY valid JSON.'
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => "data:image/jpeg;base64,{$imageData}"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'max_tokens' => 500
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            Log::info('ChatGPT API response received', ['response' => $result]);
            
            if (isset($result['choices'][0]['message']['content'])) {
                $content = $result['choices'][0]['message']['content'];
                
                // Log the raw content for debugging
                Log::debug('Raw content from ChatGPT:', ['content' => $content]);
                
                // If we have offer and image IDs, we should process the product data
                if ($offer && $offerImage) {
                    $this->processProductData($content, $offer, $offerImage);
                }
                
                return $content;
            } else {
                Log::warning('No valid content found in ChatGPT response', ['response' => $result]);
                return '';
            }
            
        } catch (\Exception $e) {
            $errorMessage = 'Error analyzing image with ChatGPT: ' . $e->getMessage();
            sendToTelegram($errorMessage);
            Log::error($errorMessage, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return '';
        }
    }
    
    /**
     * Test if the OpenAI API key is valid by making a simple request
     *
     * @param string $apiKey The OpenAI API key to test
     * @return bool Whether the API key is valid
     */
    private function testOpenAIAccess($apiKey)
    {
        try {            
            $client = new Client();
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo', // Use a simpler model for testing
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => 'Hello, this is a test message. Please respond with "API is working".'
                        ]
                    ],
                    'max_tokens' => 50
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            return isset($result['choices'][0]['message']['content']);
        } catch (\Exception $e) {
            $errorMessage = 'API test exception: ' . $e->getMessage();
            sendToTelegram($errorMessage);
            Log::error($errorMessage, [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }

    /**
     * Process product data from ChatGPT response and store it
     *
     * @param string $content The content returned from ChatGPT
     * @param Offer $offer The offer being processed
     * @param OfferImage $offerImage The offer image being processed
     * @return void
     */
    private function processProductData($content, Offer $offer, OfferImage $offerImage)
    {
        try {
            // Try to parse JSON from the response
            $productData = null;
            
            // First, try to decode the content directly in case it's clean JSON
            $productData = json_decode($content, true);
            
            // Log the parsed data
            Log::debug('Initial JSON parse result', ['data' => $productData]);
            
            // If that didn't work, try to extract JSON from the content
            if (empty($productData) || !is_array($productData)) {
                $jsonStart = strpos($content, '{');
                $jsonEnd = strrpos($content, '}');
                
                // Check if it might be an array of objects
                $arrayStart = strpos($content, '[');
                $arrayEnd = strrpos($content, ']');
                
                if ($arrayStart !== false && $arrayEnd !== false && $arrayEnd > $arrayStart) {
                    // Extract array content
                    $jsonContent = substr($content, $arrayStart, $arrayEnd - $arrayStart + 1);
                    $productData = json_decode($jsonContent, true);
                    
                    Log::debug('Extracted array content', [
                        'json_content' => $jsonContent,
                        'decoded_data' => $productData
                    ]);
                } else if ($jsonStart !== false && $jsonEnd !== false && $jsonEnd > $jsonStart) {
                    // Extract object content
                    $jsonContent = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
                    $productData = json_decode($jsonContent, true);
                    
                    Log::debug('Extracted object content', [
                        'json_content' => $jsonContent,
                        'decoded_data' => $productData
                    ]);
                }
            }
            
            // If we still couldn't parse JSON, try to extract structured data from text
            if (empty($productData) || !is_array($productData)) {
                Log::info('Falling back to text extraction for: ' . $content);
                $productData = $this->extractProductDataFromText($content);
            }
            
            // If we have valid product data, store it
            if (!empty($productData) && is_array($productData)) {
                Log::info('Final extracted product data: ' . json_encode($productData));
                
                // Check if we have a single product or an array of products
                if (isset($productData['name'])) {
                    // Single product
                    Log::debug('Processing single product');
                    $this->storeProductData($productData, $offer, $offerImage);
                } else {
                    // Could be an array of products
                    $productsStored = 0;
                    $totalProducts = count($productData);
                    
                    Log::info("Found potential array of $totalProducts products to process");
                    
                    foreach ($productData as $key => $item) {
                        // Check if this is a valid product entry
                        if (is_array($item) && isset($item['name'])) {
                            Log::debug('Processing product from array', ['index' => $key, 'product' => $item]);
                            $this->storeProductData($item, $offer, $offerImage);
                            $productsStored++;
                            
                            if (function_exists('sendToTelegram')) {
                                sendToTelegram("Stored product $productsStored/$totalProducts: " . $item['name']);
                            }
                        }
                    }
                    
                    if ($productsStored == 0) {
                        // If no products were stored, maybe the structure is different
                        Log::warning('No products were stored from array. Check the structure: ' . json_encode($productData));
                    } else {
                        Log::info("Successfully stored $productsStored products");
                    }
                }
            } else {
                Log::warning('Failed to extract structured product data from: ' . $content);
            }
        } catch (\Exception $e) {
            $errorMessage = 'Error processing product data: ' . $e->getMessage();
            Log::error($errorMessage, [
                'content' => $content,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Don't let the exception propagate - just log it
            if (function_exists('sendToTelegram')) {
                sendToTelegram($errorMessage);
            }
        }
    }
    
    /**
     * Extract product data from text when it's not in a clean JSON format
     * 
     * @param string $text The text to parse
     * @return array|null The extracted product data or null if parsing failed
     */
    private function extractProductDataFromText($text)
    {
        $productData = [];
        
        // Log the text for debugging
        Log::debug('Extracting product data from text', ['text' => $text]);
        
        // Try to extract a simple name-value pair format
        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            // Skip empty lines
            if (empty(trim($line))) continue;
            
            // Skip lines that look like headers or formatting
            if (preg_match('/^[\s\-\*\+]+$/', $line)) continue;
            
            // Try to match "key: value" pattern (more forgiving pattern)
            if (preg_match('/^\s*"?([^":{\[\n]+)"?\s*:?\s*"?([^"}\],\n]+)"?\s*[,]?$/i', $line, $matches)) {
                $key = strtolower(trim($matches[1]));
                $value = trim($matches[2]);
                
                // Skip empty values or values that are just a colon
                if (empty($value) || $value === ':') continue;
                
                // Remove trailing commas, quotes, etc.
                $value = rtrim($value, '",\'');
                
                if (in_array($key, ['name', 'product', 'product name'])) {
                    $productData['name'] = $value;
                } else if (in_array($key, ['variant', 'weight', 'value', 'type', 'size'])) {
                    $productData['variant'] = $value;
                } else if (in_array($key, ['quantity', 'qty', 'amount'])) {
                    // Try to extract just the numeric part if there's text
                    if (preg_match('/(\d+(?:\.\d+)?)/', $value, $numMatch)) {
                        $productData['quantity'] = (float)$numMatch[1];
                    } else {
                        $productData['quantity'] = is_numeric($value) ? (float)$value : null;
                    }
                } else if ($key === 'unit') {
                    $productData['unit'] = $value;
                } else if ($key === 'price') {
                    // Strip currency symbols if present and extract numeric value
                    if (preg_match('/(\d+(?:[\.,]\d+)?)/', $value, $priceMatch)) {
                        $price = str_replace(',', '.', $priceMatch[1]);
                        $productData['price'] = (float)$price;
                    } else {
                        $price = preg_replace('/[^\d.,]/', '', $value);
                        $productData['price'] = is_numeric($price) ? (float)$price : null;
                    }
                }
            }
        }
        
        // If we couldn't extract any data using line-by-line approach, try the regex method
        if (empty($productData) || !isset($productData['name'])) {
            // Extract name - try multiple patterns
            if (preg_match('/(?:"?name"?\s*[:=]\s*"?([^"\n,}]+)"?|"?product"?\s*[:=]\s*"?([^"\n,}]+)"?)/i', $text, $matches)) {
                if (!empty($matches[1])) {
                    $productData['name'] = trim($matches[1]);
                } else if (!empty($matches[2])) {
                    $productData['name'] = trim($matches[2]);
                }
            }
            
            // Extract variant/weight/value
            if (preg_match('/(?:"?(?:variant|weight|value|type|size)"?\s*[:=]\s*"?([^"\n,}]+)"?)/i', $text, $matches)) {
                if (!empty($matches[1])) {
                    $productData['variant'] = trim($matches[1]);
                }
            }
            
            // Extract quantity
            if (preg_match('/(?:"?(?:quantity|qty|amount)"?\s*[:=]\s*"?(\d+(?:\.\d+)?)"?)/i', $text, $matches)) {
                if (!empty($matches[1])) {
                    $productData['quantity'] = (float)$matches[1];
                }
            }
            
            // Extract unit
            if (preg_match('/(?:"?unit"?\s*[:=]\s*"?([^"\n,}]+)"?)/i', $text, $matches)) {
                if (!empty($matches[1])) {
                    $productData['unit'] = trim($matches[1]);
                }
            }
            
            // Extract price - try multiple formats
            if (preg_match('/(?:"?price"?\s*[:=]\s*"?(\d+(?:[\.,]\d+)?)"?)/i', $text, $matches)) {
                if (!empty($matches[1])) {
                    $price = str_replace(',', '.', $matches[1]);
                    $productData['price'] = (float)$price;
                }
            }
        }
        
        // Log the extracted data
        Log::debug('Extracted product data', ['data' => $productData]);
        
        // If we have a name but nothing else, it's a valid product
        return !empty($productData['name']) ? $productData : null;
    }
    
    /**
     * Store product data in the database
     * 
     * @param array $productData The product data to store
     * @param Offer $offer The offer being processed
     * @param OfferImage $offerImage The offer image being processed
     * @return void
     */
    private function storeProductData($productData, Offer $offer, OfferImage $offerImage)
    {
        DB::beginTransaction();
        
        try {
            // Validate the offer image exists
            if (!$offerImage || !$offerImage->exists) {
                Log::error('Invalid offer image ID', ['offer_image_id' => $offerImage->id ?? null]);
                throw new \Exception('Invalid offer image ID');
            }
            
            // Validate product data has a valid name
            if (empty($productData['name']) || $productData['name'] === ':') {
                Log::error('Invalid product name', ['product_data' => $productData]);
                throw new \Exception('Invalid product name');
            }
            
            Log::info('Processing product', [
                'name' => $productData['name'],
                'offer_id' => $offer->id,
                'image_id' => $offerImage->id,
                'price' => $productData['price'] ?? 'not set',
                'quantity' => $productData['quantity'] ?? 'not set'
            ]);
            
            // Find or create product
            $product = $this->findOrCreateProduct($productData['name']);
            
            // Clean up variant and unit if they're just colons
            $variant = isset($productData['variant']) && $productData['variant'] !== ':' 
                ? $productData['variant'] 
                : null;
                
            $unit = isset($productData['unit']) && $productData['unit'] !== ':' 
                ? $productData['unit'] 
                : null;
            
            // Create offer product entry
            $offerProduct = new OfferProduct([
                'product_id' => $product->id,
                'offer_id' => $offer->id,
                'offer_image_id' => $offerImage->id,
                'variant' => $variant,
                'unit' => $unit,
                'quantity' => $productData['quantity'] ?? null,
                'price' => $productData['price'] ?? null,
                'extracted_data' => json_encode($productData)
            ]);
            
            $offerProduct->save();
            
            DB::commit();
            
            $logMessage = 'Successfully stored product: ' . $product->name . ' for offer #' . $offer->id;
            if ($variant) {
                $logMessage .= " (variant: $variant)";
            }
            if ($productData['price'] ?? false) {
                $logMessage .= " - Price: " . $productData['price'];
            }
            
            Log::info($logMessage);
            if (function_exists('sendToTelegram')) {
                sendToTelegram($logMessage);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Error storing product data: ' . $e->getMessage();
            Log::error($errorMessage, [
                'product_data' => $productData,
                'offer_id' => $offer->id,
                'offer_image_id' => $offerImage->id ?? null,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            if (function_exists('sendToTelegram')) {
                sendToTelegram($errorMessage);
            }
        }
    }
    
    /**
     * Find an existing product by name or create a new one
     * 
     * @param string $name The product name
     * @return Product The found or newly created product
     */
    private function findOrCreateProduct($name)
    {
        try {
            // Try to find existing product by name
            $product = Product::where('name', $name)->first();
            
            if (!$product) {
                // Create a new product if none exists
                $product = new Product([
                    'name' => $name
                    // Add default values for other fields if needed
                ]);
                
                $product->save();
                $message = 'Created new product: ' . $name . ' (ID: ' . $product->id . ')';
                Log::info($message);
                if (function_exists('sendToTelegram')) {
                    sendToTelegram($message);
                }
            } else {
                $message = 'Found existing product: ' . $name . ' (ID: ' . $product->id . ')';
                Log::info($message);
                if (function_exists('sendToTelegram')) {
                    sendToTelegram($message);
                }
            }
            
            return $product;
        } catch (\Exception $e) {
            Log::error('Error finding or creating product', [
                'name' => $name,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e; // Re-throw the exception to be caught by the calling method
        }
    }

    /**
     * Delete a single offer image and its associated offer_product records
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOfferImage($id)
    {
        try {
            DB::beginTransaction();
            
            $offerImage = OfferImage::findOrFail($id);
            
            // Delete related offer_product records first
            $deletedProducts = OfferProduct::where('offer_image_id', $offerImage->id)->delete();
            Log::info("Deleted {$deletedProducts} product records associated with image ID: {$offerImage->id}");
            
            // Delete the image file
            if ($offerImage->image && Storage::disk('public')->exists($offerImage->image)) {
                Storage::disk('public')->delete($offerImage->image);
            }
            
            // Delete the image record
            $offerImage->delete();
            
            DB::commit();
            return response()->json([
                'success' => true, 
                'message' => 'Offer image and related products deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting offer image: ' . $e->getMessage(), [
                'image_id' => $id,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Error deleting offer image: ' . $e->getMessage()
            ], 500);
        }
    }
}
