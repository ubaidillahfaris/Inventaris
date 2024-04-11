<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'periode_start',
        'periode_end',
        'stok_awal',
        'stok_fisik',
        'stok_akhir',
        'keterangan',
        'selisih'
    ];

    public function produk(){
        return $this->hasOne(Produk::class,'id','produk_id');
    }
}
