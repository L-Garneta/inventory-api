<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /*public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // total barang
        $totalBarang = Item::count();

        // barang kritis
        $barangKritis = Item::whereColumn('stok', '<=', 'stok_minimum')->count();

        $barangKritisList = Item::whereColumn('stok', '<=', 'stok_minimum')
            ->get(['id', 'kode', 'nama', 'stok', 'stok_minimum']);

        // transaksi masuk bulan ini
        $totalMasuk = TransaksiMasuk::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->sum('jumlah');

        // transaksi keluar bulan ini
        $totalKeluar = TransaksiKeluar::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->sum('jumlah');

        return response()->json([
            'totalBarang' => $totalBarang,
            'barangKritis' => $barangKritis,
            'totalMasukBulan' => $totalMasuk,
            'totalKeluarBulan' => $totalKeluar,
            'bulan' => Carbon::now()->translatedFormat('F Y'),
            'barangKritisList' => $barangKritisList
        ]);
    }*/

    public function index()
    {
        $totalBarang = Item::count();
        return response()->json([
            'totalBarang' => 0
        ]);

        $barangKritis = Item::whereColumn('stok', '<=', 'stok_minimum')->count();
    }

}