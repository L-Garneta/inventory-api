<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    // 🔍 ambil transaksi yang belum diproses
    public function pending()
    {
        $data = TransaksiMasuk::where('status', 'pending')
            ->with('item')
            ->get();

        return response()->json($data);
    }

    // ⚡ generate inventaris
    public function generate(Request $request)
{
    $transaksi = TransaksiMasuk::with('item')->findOrFail($request->transaksi_id);

    $ruangan = $request->ruangan;
    $tanggal = $transaksi->tanggal;

    $bulan = date('m', strtotime($tanggal));
    $tahun = date('Y', strtotime($tanggal));

    $itemId = $transaksi->item_id;
    $kodeBarang = $transaksi->item->kode;
    $jumlah = $transaksi->jumlah;

    // hitung urutan terakhir
    $lastNumber = Inventaris::where('item_id', $itemId)->count();

    $dataInsert = [];

    for ($i = 1; $i <= $jumlah; $i++) {
        $urutan = str_pad($lastNumber + $i, 3, '0', STR_PAD_LEFT);

        $kode = "KPRDS/{$kodeBarang}/{$bulan}/{$tahun}/{$ruangan}/{$urutan}";

        $dataInsert[] = [
            'kode_inventaris' => $kode, // ✅ pakai kode baru
            'item_id' => $itemId,
            'transaksi_masuk_id' => $transaksi->id,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    Inventaris::insert($dataInsert);

    $transaksi->update([
        'status' => 'completed'
    ]);

    return response()->json([
        'message' => 'Inventaris berhasil dibuat'
    ]);
}

    // 📋 semua inventaris
    public function index()
    {
        $data = Inventaris::with(['item', 'transaksiMasuk'])->get();
        return response()->json($data);
    }

    // ✏️ update kode inventaris
    public function update(Request $request, $id)
    {
        $inventaris = Inventaris::findOrFail($id);

        $request->validate([
            'kode_inventaris' => 'required|unique:inventaris,kode_inventaris,' . $id
        ]);

        $inventaris->update([
            'kode_inventaris' => $request->kode_inventaris
        ]);

        $request->validate([
            'kode_inventaris' => [
                'required',
                'regex:/^KPRDS\/[A-Z0-9]+\/\d{2}\/\d{4}\/[A-Z_]+\/\d{3}$/',
                'unique:inventaris,kode_inventaris,' . $id
            ]
        ]);

        return response()->json([
            'message' => 'Kode berhasil diupdate'
        ]);
    }
}