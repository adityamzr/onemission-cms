<?php

use App\Livewire\Categories\CategoryForm;
use App\Livewire\Categories\CategoryList;
use App\Livewire\Overview;
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

Route::get('/categories', CategoryList::class)->name('categories');

Route::get('/tags', TagList::class)->name('tags');
