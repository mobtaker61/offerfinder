<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmirateController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// Front Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
Route::get('/get-branches-by-market', [BranchController::class, 'getBranchesByMarket'])->name('getBranchesByMarket');
Route::get('/get-branches-by-market-and-emirate', [BranchController::class, 'getBranchesByMarketAndEmirate'])->name('getBranchesByMarketAndEmirate');
Route::get('/get-offers-by-branch', [BranchController::class, 'getOffersByBranch'])->name('getOffersByBranch');
Route::get('/get-markets-by-emirate', [MarketController::class, 'getMarketsByEmirate'])->name('getMarketsByEmirate');

Route::get('/offers', [OfferController::class, 'list'])->name('offer.list'); // Ensure this line is present
Route::get('/offer/{offer}', [OfferController::class, 'show'])->name('offer.show');
Route::get('/offer/card/{id}', [OfferController::class, 'card'])->name('offer.card');
Route::post('/offers/filter', [OfferController::class, 'filter'])->name('offer.filter');
Route::post('/offers/{offer}/toggle-vip', [OfferController::class, 'toggleVip'])->name('offers.toggleVip');

// Market offers routes
Route::get('/offers/market/{market}', [App\Http\Controllers\OfferController::class, 'getOffersByMarket'])
    ->name('offers.by-market');
// Emirate offers routes
Route::get('/offers/emirate/{emirate}', [App\Http\Controllers\OfferController::class, 'getOffersByEmirate'])
    ->name('offers.by-emirate');

// Admin Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('markets', MarketController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('offers', OfferController::class);
    Route::delete('offer_images/{offerImage}', [OfferImageController::class, 'destroy'])->name('offer_images.destroy');
    Route::resource('notifications', NotificationController::class);
    Route::post('/save-fcm-token', [FcmTokenController::class, 'store']);

    Route::resource('emirates', EmirateController::class);

    Route::resource('newsletters', NewsletterController::class)->except(['edit', 'update']);
    Route::post('newsletters/{newsletter}/send', [NewsletterController::class, 'send'])->name('newsletters.send');
});

require __DIR__ . '/auth.php';
