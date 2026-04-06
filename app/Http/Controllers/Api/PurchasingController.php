<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchasing;
use App\Models\Item;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasingController extends Controller
{
    // GET semua purchasing
    public function index()
    {
        $data = Purchasing::with('item')->latest()->get();

        return response()->json($data);
    }

    // TAMBAH purchasing
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'nullable',
            'tanggal_pesan' => 'required|date'
        ]);

        $data['status'] = 'dipesan';

        $purchasing = Purchasing::create($data);

        return response()->json([
            'message' => 'Purchasing berhasil dibuat',
            'data' => $purchasing
        ]);
    }

    // UPDATE STATUS / EDIT
    public function update(Request $request, $id)
    {
        $purchasing = Purchasing::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:dipesan,dikirim,sampai',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            // 🔥 update data
            $purchasing->update($data);

            // 🔥 refresh biar ambil data terbaru
            $purchasing->refresh();

            // 🔥 CEK kalau status sampai & belum diproses
            if (
                $data['status'] === 'sampai' &&
                $purchasing->is_processed !== true
            ) {

                // 🔥 CEK biar tidak double insert
                $exists = TransaksiMasuk::where(
                    'keterangan',
                    'like',
                    '%purchasing ID ' . $purchasing->id . '%'
                )->exists();

                if (!$exists) {

                    $item = Item::findOrFail($purchasing->item_id);

                    // ➕ insert ke transaksi masuk
                    TransaksiMasuk::create([
                        'item_id' => $item->id,
                        'tanggal' => now(),
                        'jumlah' => $purchasing->jumlah,
                        'supplier' => $purchasing->supplier ?? '-',
                        'keterangan' => 'Dari purchasing ID ' . $purchasing->id,
                        'status' => 'normal'
                    ]);

                    // ➕ update stok
                    $item->stok += $purchasing->jumlah;
                    $item->save();

                    // 🔥 tandai sudah diproses
                    $purchasing->is_processed = true;
                    $purchasing->save();
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Purchasing berhasil diupdate',
                'data' => $purchasing
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal update purchasing',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE (optional kalau mau)
    public function destroy($id)
    {
        $purchasing = Purchasing::findOrFail($id);
        $purchasing->delete();

        return response()->json([
            'message' => 'Purchasing berhasil dihapus'
        ]);
    }
}