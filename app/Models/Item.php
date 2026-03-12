<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'ruangan',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimum'
    ];

    public function transaksiMasuk()
    {
        return $this->hasMany(TransaksiMasuk::class);
    }

    public function transaksiKeluar()
    {
        return $this->hasMany(TransaksiKeluar::class);
    }
}