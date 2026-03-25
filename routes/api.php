<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TransaksiMasukController;
use App\Http\Controllers\Api\TransaksiKeluarController;
use App\Http\Controllers\Api\DashboardController;

Route::get('/items', [ItemController::class, 'index']);
Route::post('/items', [ItemController::class, 'store']);
Route::post('/transaksi-masuk', [TransaksiMasukController::class, 'store']);
Route::post('/transaksi-keluar', [TransaksiKeluarController::class, 'store']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::delete('/transaksi-masuk/{id}', [TransaksiMasukController::class, 'destroy']);
Route::delete('/transaksi-keluar/{id}', [TransaksiKeluarController::class, 'destroy']);
Route::delete('/items/{id}', [ItemController::class, 'destroy']);