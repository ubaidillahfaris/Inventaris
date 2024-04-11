<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{

    public function stok_update(int $produk_id, int $stok){
        try {
            Stok::where('produk_id',$produk_id)
            ->update([
                'jumlah' => $stok
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function stock_add(int $produk_id, int $jumlah):void{
        try {
            $stok = Stok::where('produk_id',$produk_id)->first();
            $totalStok = !isset($stok) ? 0 : $stok->jumlah;
            Stok::updateOrCreate(
                [
                    'produk_id' => $produk_id
                ],
                [
                    'jumlah' => $totalStok + $jumlah
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function stock_sub(int $produk_id, int $jumlah){
        try {
            $stok = Stok::where('produk_id',$produk_id)->first();
            $totalStok = !isset($stok) ? 0 : $stok->jumlah;
            Stok::updateOrCreate(
                [
                    'produk_id' => $produk_id
                ],
                [
                    'jumlah' => $totalStok - $jumlah
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
