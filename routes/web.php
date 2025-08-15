<?php

use App\Livewire\Categories\CategoryForm;
use App\Livewire\Categories\CategoryList;
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

Route::prefix('products')->group(function () {
    Route::get('/', ProductList::class)->name('products');
    Route::get('/create', ProductForm::class)->name('products.create');
    Route::get('/{id}/edit', ProductForm::class)->name('products.edit');
    Route::get('/{id}/show', VariantList::class)->name('products.show');
    Route::get('/{id}/variants/create', VariantForm::class)->name('variants.create');
    Route::get('/{id}/variants/{variantId}/edit', VariantForm::class)->name('variants.edit');
});

// Route::get('')

Route::get('/categories', CategoryList::class)->name('categories');

Route::get('/tags', TagList::class)->name('tags');
