<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'jumlah',
        'exp_date',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class,'produk_id','id');
    }

    public function lokasi(){
        return $this->hasMany(StorageLocation::class,'transaksi_masuk_id','id');
    }
}

