<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TransaksiMasukController;
use App\Http\Controllers\Api\TransaksiKeluarController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PurchasingController;

Route::get('/items', [ItemController::class, 'index']);
Route::post('/items', [ItemController::class, 'store']);
Route::delete('/items/{id}', [ItemController::class, 'destroy']);
Route::put('/items/{id}', [ItemController::class, 'update']);

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::post('/transaksi-masuk', [TransaksiMasukController::class, 'store']);
Route::delete('/transaksi-masuk/{id}', [TransaksiMasukController::class, 'destroy']);
Route::get('/transaksi-masuk', [TransaksiMasukController::class, 'index']);

Route::get('/transaksi-keluar', [TransaksiKeluarController::class, 'index']);
Route::delete('/transaksi-keluar/{id}', [TransaksiKeluarController::class, 'destroy']);
Route::post('/transaksi-keluar', [TransaksiKeluarController::class, 'store']);

Route::get('/purchasing', [PurchasingController::class, 'index']);
Route::post('/purchasing', [PurchasingController::class, 'store']);
Route::put('/purchasing/{id}', [PurchasingController::class, 'update']);
Route::delete('/purchasing/{id}', [PurchasingController::class, 'destroy']);
