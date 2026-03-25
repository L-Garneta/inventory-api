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
}