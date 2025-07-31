<?php

use App\Livewire\Overview;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/overview', Overview::class);
