<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cmpho\dataController;

Route::prefix('cmpho')->group(function () {
    Route::get('/', [dataController::class, 'index'])->middleware(['auth', 'verified'])->name('cmpho.index');
    Route::get('process', [dataController::class, 'process'])->middleware(['auth', 'verified'])->name('cmpho.process');
    Route::get('report', [dataController::class, 'report'])->middleware(['auth', 'verified'])->name('cmpho.report');
});