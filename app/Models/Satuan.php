<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satuan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['uuid','name'];

    public function produk(){
        return $this->hasMany(Produk::class,'satuan_id','id');
    }
}
