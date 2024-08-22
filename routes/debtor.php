<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Debtor\debtor;

Route::prefix('debtor')->group(function () {
    Route::get('/', [debtor::class, 'index'])->middleware(['auth', 'verified'])->name('debtor.index');
    Route::get('list', [debtor::class, 'list'])->middleware(['auth', 'verified'])->name('debtor.list');
    Route::get('search', [debtor::class, 'search'])->middleware(['auth', 'verified'])->name('debtor.search');
    Route::get('list/{id}', [debtor::class, 'show'])->middleware(['auth', 'verified'])->name('debtor.show');
    Route::post('claim-import', [debtor::class, 'import'])->middleware(['auth', 'verified'])->name('debtor.import');
    Route::get('claim-send', [debtor::class, 'send'])->middleware(['auth', 'verified'])->name('debtor.send');
    Route::get('create', [debtor::class, 'create'])->middleware(['auth', 'verified'])->name('debtor.create');
    Route::post('create/add', [debtor::class, 'add'])->middleware(['auth', 'verified'])->name('debtor.add');
    Route::get('/hospital', [debtor::class, 'hospital'])->middleware(['auth', 'verified'])->name('debtor.hospital');
    Route::get('/hospital/{id}', [debtor::class, 'hospitalList'])->middleware(['auth', 'verified'])->name('debtor.hospital.list');
});