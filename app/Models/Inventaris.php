<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';

    protected $fillable = [
        'kode_inventaris',
        'item_id',
        'transaksi_masuk_id',
        'status'
    ];

    // relasi ke item (master barang)
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // relasi ke transaksi masuk
    public function transaksiMasuk()
    {
        return $this->belongsTo(TransaksiMasuk::class);
    }
}