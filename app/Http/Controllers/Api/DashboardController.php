<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalBarang = Item::count();

        $barangKritisList = Item::whereColumn('stok', '<=', 'stok_minimum')
            ->get(['id', 'kode', 'nama', 'stok', 'stok_minimum']);

        $barangKritis = $barangKritisList->count();

        $totalMasuk = TransaksiMasuk::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->sum('jumlah');

        $totalKeluar = TransaksiKeluar::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->sum('jumlah');

        return response()->json([
            'totalBarang' => $totalBarang,
            'barangKritis' => $barangKritis,
            'totalMasukBulan' => $totalMasuk,
            'totalKeluarBulan' => $totalKeluar,
            'bulan' => Carbon::now()->translatedFormat('F Y'),
            'barangKritisList' => $barangKritisList,
        ]);
    }
}