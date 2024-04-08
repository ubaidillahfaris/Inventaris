<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['uuid','name', 'reg', 'satuan_id'];

    public function satuan(){
        return $this->hasOne(Satuan::class,'id','satuan_id');
    }
}
