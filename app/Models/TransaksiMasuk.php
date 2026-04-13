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
        'status',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }

}