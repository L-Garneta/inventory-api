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
        $transaksi = TransaksiMasuk::findOrFail($request->transaksi_id);

        $jumlah = $transaksi->jumlah;
        $itemId = $transaksi->item_id;

        $lastNumber = Inventaris::where('item_id', $itemId)->count();

        $dataInsert = [];

        for ($i = 1; $i <= $jumlah; $i++) {
            $urutan = str_pad($lastNumber + $i, 3, '0', STR_PAD_LEFT);

            $dataInsert[] = [
                'kode_inventaris' => "INV-{$itemId}-{$urutan}",
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

        return response()->json([
            'message' => 'Kode berhasil diupdate'
        ]);
    }
}