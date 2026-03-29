<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;

class TransaksiMasukController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1'
        ]);

        $item = Item::findOrFail($request->item_id);

        $transaksi = TransaksiMasuk::create([
            'item_id' => $request->item_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan
        ]);

        // update stok
        $item->stok = $item->stok + $request->jumlah;
        $item->save();

        return response()->json([
            'message' => 'Transaksi masuk berhasil',
            'data' => $transaksi
        ]);
    }

    public function destroy($id)
    {
    $transaksi = TransaksiMasuk::find($id);

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

    public function index()
    {
        return TransaksiMasuk::all();
    }
}