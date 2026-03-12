<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    protected $table = 'transaksi_masuk';

    protected $fillable = [
        'item_id',
        'tanggal',
        'jumlah',
        'supplier',
        'keterangan'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}