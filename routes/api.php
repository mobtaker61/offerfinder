<?php

use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\EmirateController;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\OfferImageController;
use App\Http\Controllers\Api\FcmTokenController;
use Illuminate\Support\Facades\Route;

// API Routes - prefix 'api' already applied via RouteServiceProvider
Route::middleware('api')->group(function () {
    // Markets
    Route::apiResource('markets', MarketController::class);
    Route::get('markets/by-emirate/{emirate}', [MarketController::class, 'getMarketsByEmirate']);
    
    // Branches
    Route::apiResource('branches', BranchController::class);
    Route::get('branches/by-market/{market}', [BranchController::class, 'getBranchesByMarket']);
    Route::post('branches/by-market-and-emirate', [BranchController::class, 'getBranchesByMarketAndEmirate']);
    Route::get('branches/{branch}/offers', [BranchController::class, 'getOffersByBranch']);
    
    // Offers
    Route::apiResource('offers', OfferController::class);
    Route::get('offers/card/{id}', [OfferController::class, 'card']);
    Route::get('offers/by-market/{market}', [OfferController::class, 'getOffersByMarket']);
    Route::get('offers/by-emirate/{emirate}', [OfferController::class, 'getOffersByEmirate']);
    Route::post('offers/filter', [OfferController::class, 'filter']);
    Route::post('offers/{offer}/toggle-vip', [OfferController::class, 'toggleVip']);
    
    // Emirates
    Route::apiResource('emirates', EmirateController::class);
    
    // Notifications
    Route::apiResource('notifications', NotificationController::class);
    
    // Newsletters
    Route::post('subscribe', [NewsletterController::class, 'subscribe']);
    
    // FCM Token
    Route::post('fcm-token', [FcmTokenController::class, 'store']);
});