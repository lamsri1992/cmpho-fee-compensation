<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\dashboard;

Route::prefix('/')->group(function () {
    Route::get('dashboard', [dashboard::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('nhso', [dashboard::class, 'nhso'])->middleware(['auth', 'verified'])->name('nhso');
});