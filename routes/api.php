<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TransaksiMasukController;
use App\Http\Controllers\Api\TransaksiKeluarController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PurchasingController;
use App\Http\Controllers\Api\InventarisController;
use App\Http\Controllers\Api\AuthController;

use Illuminate\Support\Facades\Artisan;

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

Route::get('/inventaris', [InventarisController::class, 'index']);
Route::get('/inventaris/pending', [InventarisController::class, 'pending']);
Route::post('/inventaris/generate', [InventarisController::class, 'generate']);
Route::put('/inventaris/{id}', [InventarisController::class, 'update']);
#Route::delete('/inventaris/{id}', [InventarisController::class, 'destroy']);

Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'MIGRATE SUCCESS';
});

#route middleware
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/items', [ItemController::class, 'index']);

    // 🔥 KHUSUS ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::delete('/items/{id}', [ItemController::class, 'destroy']);
    });

});