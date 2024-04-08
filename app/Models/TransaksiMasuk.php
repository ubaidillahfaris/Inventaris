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
        return $this->belongsTo(Produk::class,'id','produk_id');
    }
}
