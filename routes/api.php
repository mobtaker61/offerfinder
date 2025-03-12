<?php

use App\Http\Controllers\MarketController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::apiResource('markets', MarketController::class);
Route::apiResource('branches', BranchController::class);
Route::apiResource('offers', OfferController::class);