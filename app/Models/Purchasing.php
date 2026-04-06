<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchasing extends Model
{
    protected $table = 'purchasing';

    protected $fillable = [
        'item_id',
        'jumlah',
        'supplier',
        'status',
        'tanggal_pesan',
        'is_processed'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}