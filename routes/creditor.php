<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Creditor\creditor;

Route::prefix('creditor')->group(function () {
    Route::get('/', [creditor::class, 'index'])->middleware(['auth', 'verified'])->name('creditor.index');
    Route::get('list', [creditor::class, 'list'])->middleware(['auth', 'verified'])->name('creditor.list');
});