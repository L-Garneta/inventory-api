<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TransaksiMasukController;
use App\Http\Controllers\Api\TransaksiKeluarController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PurchasingController;
use App\Http\Controllers\Api\InventarisController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // =========================
    // READ (ADMIN + STAFF)
    // =========================
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/transaksi-masuk', [TransaksiMasukController::class, 'index']);
    Route::get('/transaksi-keluar', [TransaksiKeluarController::class, 'index']);
    Route::get('/purchasing', [PurchasingController::class, 'index']);
    Route::get('/inventaris', [InventarisController::class, 'index']);
    Route::get('/inventaris/pending', [InventarisController::class, 'pending']);

    // =========================
    // ADMIN ONLY (CRUD)
    // =========================
    Route::middleware('role:admin')->group(function () {

        // ITEMS
        Route::post('/items', [ItemController::class, 'store']);
        Route::put('/items/{id}', [ItemController::class, 'update']);
        Route::delete('/items/{id}', [ItemController::class, 'destroy']);

        // TRANSAKSI MASUK
        Route::post('/transaksi-masuk', [TransaksiMasukController::class, 'store']);
        Route::delete('/transaksi-masuk/{id}', [TransaksiMasukController::class, 'destroy']);

        // TRANSAKSI KELUAR
        Route::post('/transaksi-keluar', [TransaksiKeluarController::class, 'store']);
        Route::delete('/transaksi-keluar/{id}', [TransaksiKeluarController::class, 'destroy']);

        // PURCHASING
        Route::post('/purchasing', [PurchasingController::class, 'store']);
        Route::put('/purchasing/{id}', [PurchasingController::class, 'update']);
        Route::delete('/purchasing/{id}', [PurchasingController::class, 'destroy']);

        // INVENTARIS
        Route::post('/inventaris/generate', [InventarisController::class, 'generate']);
        Route::put('/inventaris/{id}', [InventarisController::class, 'update']);
    });
});