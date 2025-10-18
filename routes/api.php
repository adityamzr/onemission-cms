<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
  Route::post('/orders/checkout', [OrderController::class, 'store']);
  Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel']);
  Route::post('/orders/payment-callback', [OrderController::class, 'callback']);
  Route::post('/orders/{orderNumber}/received', [OrderController::class, 'received']);
});
