<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiKeluarController extends Controller
{
    public function store(Request $request)
    {
    return DB::transaction(function () use ($request) {

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1'
        ]);

        $item = Item::findOrFail($request->item_id);

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

        $item->stok -= $request->jumlah;
        $item->save();

        return response()->json([
            'message' => 'Transaksi keluar berhasil',
            'data' => $transaksi
        ]);
    });

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

    // 🔥 BALIKIN STOK
    $item = Item::find($transaksi->item_id);
    if ($item) {
        $item->stok += $transaksi->jumlah;
        $item->save();
    }

    $transaksi->delete();

    return response()->json([
        'message' => 'Transaksi berhasil dihapus'
    ]);
    }

    public function index()
    {
        return TransaksiKeluar::all();
    }
}