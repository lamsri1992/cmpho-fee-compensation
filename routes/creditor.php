<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Creditor\creditor;

Route::prefix('creditor')->group(function () {
    Route::get('/', [creditor::class, 'index'])->middleware(['auth', 'verified'])->name('creditor.index');
    Route::get('list', [creditor::class, 'list'])->middleware(['auth', 'verified'])->name('creditor.list');
    Route::get('vn/{id}', [creditor::class, 'vn'])->middleware(['auth', 'verified'])->name('creditor.vn');
    Route::get('hospital', [creditor::class, 'hospital'])->middleware(['auth', 'verified'])->name('creditor.hospital');
    Route::get('hospital/search/month', [creditor::class, 'hospitalSearch'])->middleware(['auth', 'verified'])->name('creditor.hospital.month');
    Route::get('hospital/{id}', [creditor::class, 'hospitalList'])->middleware(['auth', 'verified'])->name('creditor.hospital.list');
});