<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BranchController as AdminBranchController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\MarketController as AdminMarketController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmirateController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\Front\MarketController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\NeighbourController;
use App\Http\Controllers\OfferCategoryController;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\BlogController;

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
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Define market routes explicitly
    Route::get('/markets', [AdminMarketController::class, 'index'])->name('markets.index');
    Route::get('/markets/create', [AdminMarketController::class, 'create'])->name('markets.create');
    Route::post('/markets', [AdminMarketController::class, 'store'])->name('markets.store');
    Route::get('/markets/{market}/edit', [AdminMarketController::class, 'edit'])->name('markets.edit');
    Route::put('/markets/{market}', [AdminMarketController::class, 'update'])->name('markets.update');
    Route::delete('/markets/{market}', [AdminMarketController::class, 'destroy'])->name('markets.destroy');
    
    // Keep your existing toggle status route
    Route::post('markets/{market}/toggle-status', [AdminMarketController::class, 'toggleStatus'])->name('markets.toggle-status');
    
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
    Route::resource('pages', AdminPageController::class);
    Route::resource('blog', AdminBlogController::class);

    // User Management Routes
    Route::resource('users', \App\Http\Controllers\Admin\UserManagementController::class);
    Route::patch('users/{user}/toggle-active', [\App\Http\Controllers\Admin\UserManagementController::class, 'toggleActive'])->name('users.toggle-active');
});

// Pages
Route::get('pages/{slug}', [App\Http\Controllers\Front\PageController::class, 'show'])->name('pages.show');

// Sitemap Routes
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('sitemap/generate', [App\Http\Controllers\SitemapController::class, 'generate'])->name('sitemap.generate');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

require __DIR__ . '/auth.php';
