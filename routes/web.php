<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])-> name('home');
Route::get('/items', [ItemController::class, 'index'])-> name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])-> name('items.create');
Route::get('/items', [ItemController::class, 'store'])-> name('items.store');
Route::get('/items/{item}', [ItemController::class, 'show'])-> name('items.show');
Route::get('/items/{item}/edit', [ItemController::class, 'edit'])-> name('items.edit');
Route::get('/items/{item}', [ItemController::class, 'update'])-> name('items.update');
Route::get('/items/{item}', [ItemController::class, 'destroy'])-> name('items.destroy');
