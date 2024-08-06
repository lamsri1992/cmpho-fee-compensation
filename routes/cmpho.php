<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cmpho\dataController;
use App\Http\Controllers\Cmpho\configController;

Route::prefix('cmpho')->group(function () {
    Route::get('/', [dataController::class, 'index'])->middleware(['auth', 'verified'])->name('cmpho.index');
    Route::get('process', [dataController::class, 'process'])->middleware(['auth', 'verified'])->name('cmpho.process');
    Route::get('report', [dataController::class, 'report'])->middleware(['auth', 'verified'])->name('cmpho.report');
});

Route::prefix('cmpho/config')->group(function () {
    Route::get('/hospital', [configController::class, 'hospital'])->middleware(['auth', 'verified'])->name('config.hospital');
    Route::post('/hospital/create', [configController::class, 'hospitalCreate'])->middleware(['auth', 'verified'])->name('config.hospital.create');
    Route::get('/users', [configController::class, 'users'])->middleware(['auth', 'verified'])->name('config.users');
    Route::post('/user/create', [configController::class, 'userCreate'])->middleware(['auth', 'verified'])->name('config.user.create');
});