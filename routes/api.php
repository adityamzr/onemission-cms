<?php

use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
  Route::prefix('orders')->group(function () {
    Route::post('/checkout', [OrderController::class, 'store']);
    Route::post('/{orderNumber}/cancel', [OrderController::class, 'cancel']);
    Route::post('/payment-callback', [OrderController::class, 'callback']);
    Route::post('/{orderNumber}/received', [OrderController::class, 'received']);
  });

  Route::get('/banners', [BannerController::class, 'getAll']);
  Route::get('/gallery', [GalleryController::class, 'getAll']);

  Route::prefix('discount')->group(function () {
    Route::post('/check', [DiscountController::class, 'checkDiscount']);
  });
});
