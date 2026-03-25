<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKeluar extends Model
{
    protected $table = 'transaksi_keluar';

    protected $fillable = [
        'item_id',
        'tanggal',
        'jumlah',
        'penerima',
        'keterangan'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
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