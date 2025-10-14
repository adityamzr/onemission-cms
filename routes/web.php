<?php

use App\Livewire\Banner\BannerList;
use App\Livewire\Categories\CategoryList;
use App\Livewire\Discounts\DiscountList;
use App\Livewire\Galleries\GalleryList;
use App\Livewire\Orders\CancelList;
use App\Livewire\Orders\OrderDetail;
use App\Livewire\Orders\OrderHistory;
use App\Livewire\Orders\OrderList;
use App\Livewire\Outfits\OutfitForm;
use App\Livewire\Outfits\OutfitList;
use App\Livewire\Overview;
use App\Livewire\Products\ProductForm;
use App\Livewire\Products\ProductList;
use App\Livewire\Products\Variants\VariantForm;
use App\Livewire\Products\Variants\VariantList;
use App\Livewire\Tags\TagList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/overview', Overview::class)->name('overview');

// Route::middleware(['auth:sanctum', 'verified'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

// });

Route::prefix('/orders')->group(function () {
    Route::get('/', OrderList::class)->name('orders');
    Route::get('/{id}/show', OrderDetail::class)->name('orders.show');
    Route::get('/cancel', CancelList::class)->name('orders.cancel');
    Route::get('/history', OrderHistory::class)->name('orders.history');
});

Route::prefix('products')->group(function () {
    Route::get('/', ProductList::class)->name('products');
    Route::get('/create', ProductForm::class)->name('products.create');
    Route::get('/{id}/edit', ProductForm::class)->name('products.edit');
    Route::get('/{id}/show', VariantList::class)->name('products.show');
    Route::get('/{id}/variants/create', VariantForm::class)->name('variants.create');
    Route::get('/{id}/variants/{variantId}/edit', VariantForm::class)->name('variants.edit');
});

Route::prefix('outfits')->group(function () {
    Route::get('/', OutfitList::class)->name('outfits');
    Route::get('/create', OutfitForm::class)->name('outfits.create');
    Route::get('/{id}/edit', OutfitForm::class)->name('outfits.edit');
});

Route::get('/categories', CategoryList::class)->name('categories');
Route::get('/tags', TagList::class)->name('tags');
Route::get('/discounts', DiscountList::class)->name('discounts');

Route::get('/banners', BannerList::class)->name('banners');
Route::get('/galleries', GalleryList::class)->name('galleries');
