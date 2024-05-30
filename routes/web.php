<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'index'])-> name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])-> name('items.create');
Route::post('/items', [ItemController::class, 'store'])-> name('items.store');
Route::get('/items/{item}', [ItemController::class, 'show'])-> name('items.show');
Route::get('/items/{item}/edit', [ItemController::class, 'edit'])-> name('items.edit');
Route::put('/items/{item}', [ItemController::class, 'update'])-> name('items.update');
Route::put('/items/{item}/updatelocal', [ItemController::class, 'updatelocal'])-> name('items.updatelocal');
Route::delete('/items/{item}', [ItemController::class, 'destroy'])-> name('items.destroy');

//json
Route::post('/search', [ItemController::class, 'search'])-> name('items.search');
Route::get('/tags', [ItemController::class, 'tags'])-> name('items.tags');
