<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'ruangan',
        'satuan',
        'harga_beli',
        'stok',
        'stok_minimum'
    ];
}