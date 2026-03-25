<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;

class TransaksiKeluarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1'
        ]);

        $item = Item::findOrFail($request->item_id);

        // cek stok cukup atau tidak
        if ($item->stok < $request->jumlah) {
            return response()->json([
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        $transaksi = TransaksiKeluar::create([
            'item_id' => $request->item_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'penerima' => $request->penerima,
            'keterangan' => $request->keterangan
        ]);

        // kurangi stok
        $item->stok -= $request->jumlah;
        $item->save();

        return response()->json([
            'message' => 'Transaksi keluar berhasil',
            'data' => $transaksi
        ]);
    }
    
    public function destroy($id)
    {
    $transaksi = TransaksiKeluar::find($id);
        if (!$transaksi) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }
    $transaksi->delete();
        return response()->json([
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}