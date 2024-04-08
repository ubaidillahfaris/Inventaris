<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'transaksi_masuk_id',
        'label',
        'barcode_path',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class,'produk_id','id');
    }

    public function transaksi_masuk(){
        return $this->hasOne(TransaksiMasuk::class,'id','transaksi_masuk_id');
    }
}
