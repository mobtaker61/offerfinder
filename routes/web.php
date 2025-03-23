<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\BranchController as AdminBranchController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmirateController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\NeighbourController;
use App\Http\Controllers\OfferCategoryController;
use Illuminate\Support\Facades\View;

// Front Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
Route::get('/get-branches-by-market', [BranchController::class, 'getBranchesByMarket'])->name('getBranchesByMarket');
Route::get('/get-branches-by-market-and-emirate', [BranchController::class, 'getBranchesByMarketAndEmirate'])->name('getBranchesByMarketAndEmirate');
Route::get('/get-offers-by-branch', [BranchController::class, 'getOffersByBranch'])->name('getOffersByBranch');
Route::get('/get-markets-by-emirate', [MarketController::class, 'getMarketsByEmirate'])->name('getMarketsByEmirate');
Route::get('/get-districts/{emirate}', [DistrictController::class, 'getDistrictsByEmirate'])->name('districts.get');
Route::get('/get-neighbours/{district}', [NeighbourController::class, 'getNeighboursByDistrict'])->name('neighbours.get');

Route::get('/offers', [OfferController::class, 'list'])->name('offer.list');
Route::get('/offer/{offer}', [OfferController::class, 'show'])->name('offer.show');
Route::get('/offer/card/{id}', [OfferController::class, 'card'])->name('offer.card');
Route::post('/offers/filter', [OfferController::class, 'filter'])->name('offer.filter');

// Market offers routes
Route::get('/offers/market/{market}', [App\Http\Controllers\OfferController::class, 'getOffersByMarket'])
    ->name('offers.by-market');
// Emirate offers routes
Route::get('/offers/emirate/{emirate}', [App\Http\Controllers\OfferController::class, 'getOffersByEmirate'])
    ->name('offers.by-emirate');
// Market and Emirate combined offers route
Route::post('/offers/by-emirate-and-market', [OfferController::class, 'getOffersByEmirateAndMarket'])->name('offers.by-emirate-and-market');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications.update');
});

Route::group(['prefix' => 'market', 'as' => 'front.market.'], function () {
    Route::get('/', [App\Http\Controllers\Front\MarketController::class, 'index'])->name('index');
    Route::get('/{market}', [App\Http\Controllers\Front\MarketController::class, 'show'])->name('show');
    Route::get('/{market}/offers', [App\Http\Controllers\Front\MarketController::class, 'getOffersByStatus'])->name('offers');
});

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('markets', MarketController::class);
    Route::post('markets/{market}/toggle-status', [MarketController::class, 'toggleStatus'])->name('markets.toggle-status');
    
    // Offers routes
    Route::resource('offers', OfferController::class);
    Route::post('offers/{offer}/toggle-vip', [OfferController::class, 'toggleVip'])->name('offers.toggle-vip');
    Route::delete('offer-images/{id}', [OfferController::class, 'deleteOfferImage'])->name('offer-images.delete');
    
    Route::resource('branches', AdminBranchController::class);
    Route::resource('offer-images', OfferImageController::class);
    Route::resource('notifications', NotificationController::class);
    Route::resource('fcm-tokens', FcmTokenController::class);
    Route::resource('emirates', EmirateController::class);
    Route::resource('districts', DistrictController::class);
    Route::resource('neighbours', NeighbourController::class);
    Route::resource('offer-categories', OfferCategoryController::class);
    Route::resource('newsletters', NewsletterController::class)->except(['edit', 'update']);
    Route::post('newsletters/{newsletter}/send', [NewsletterController::class, 'send'])->name('newsletters.send');
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
});

// Pages
Route::get('pages/{slug}', [App\Http\Controllers\Front\PageController::class, 'show'])->name('pages.show');

// Sitemap Routes
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('sitemap/generate', [App\Http\Controllers\SitemapController::class, 'generate'])->name('sitemap.generate');

require __DIR__ . '/auth.php';
