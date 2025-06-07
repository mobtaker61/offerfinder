<?php

use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\EmirateController;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\OfferImageController;
use App\Http\Controllers\Api\FcmTokenController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\NeighbourController;
use App\Http\Controllers\Api\OfferProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserFavoriteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// API Routes - prefix 'api' already applied via RouteServiceProvider
Route::middleware('api')->group(function () {
    // Custom show route to support both id and slug (must be before resource!)
    Route::get('markets/{marketKey}', [MarketController::class, 'showByIdOrSlug']);
    // Markets resource (exclude show)
    Route::apiResource('markets', MarketController::class)->except(['show']);
    
    // Branches
    Route::apiResource('branches', BranchController::class);
    Route::get('/branches/by-market/{market}', [BranchController::class, 'getBranchesByMarket']);
    Route::post('branches/by-market-and-emirate', [BranchController::class, 'getBranchesByMarketAndEmirate']);
    Route::get('branches/{branch}/offers', [BranchController::class, 'getOffersByBranch']);
    
    // Offers
    Route::apiResource('offers', OfferController::class);
    Route::get('offers/card/{id}', [OfferController::class, 'card']);
    Route::get('offers/by-market/{market}', [OfferController::class, 'getOffersByMarket']);
    Route::get('offers/by-emirate/{emirate}', [OfferController::class, 'getOffersByEmirate']);
    Route::post('offers/by-emirate-and-market', [OfferController::class, 'getOffersByEmirateAndMarket']);
    Route::post('offers/filter', [OfferController::class, 'filter']);
    Route::post('offers/{offer}/toggle-vip', [OfferController::class, 'toggleVip']);
    Route::get('offers/{offer}/products', [OfferProductController::class, 'index']);
    
    // Emirates
    Route::apiResource('emirates', EmirateController::class);
    // Districts by emirate
    Route::get('emirates/{emirate}/districts', [DistrictController::class, 'getDistrictsByEmirate']);
    // Neighbours by district
    Route::get('districts/{district}/neighbours', [NeighbourController::class, 'getNeighboursByDistrict']);
    
    // Notifications
    Route::apiResource('notifications', NotificationController::class);
    
    // Newsletters
    Route::post('subscribe', [NewsletterController::class, 'subscribe']);
    
    // FCM Token
    Route::post('fcm-token', [FcmTokenController::class, 'store']);

    // Districts
    Route::get('/get-districts/{emirate}', [DistrictController::class, 'getDistrictsByEmirate'])->name('api.districts.get');

    // Cascading dropdowns
    Route::get('/markets/dropdown', [MarketController::class, 'dropdown']);

});

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Profile routes
    Route::get('/user/profile', [ProfileController::class, 'show']);
    Route::put('/user/profile', [ProfileController::class, 'update']);
    Route::delete('/user/avatar', [ProfileController::class, 'deleteAvatar']);

    // User Favorites
    Route::get('/favorites', [UserFavoriteController::class, 'index']);
    Route::post('/favorites', [UserFavoriteController::class, 'store']);
    Route::delete('/favorites', [UserFavoriteController::class, 'destroy']);
});