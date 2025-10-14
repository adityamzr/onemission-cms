<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
  Route::post('/orders', [OrderController::class, 'store']);
});
