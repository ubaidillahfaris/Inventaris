<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TransaksiKeluarController extends Controller
{
    public function create(Request $request){

       try {
            $request->validate([
                'produk_id' => 'required',
                'jumlah' => 'required'
            ]);

            $id = $request->produk_id;
            $jumlah = $request->jumlah;

            $produkController = new ProdukController();
            $produk = $produkController->show($id);

            if (!isset($produk)) {
                return response()
                ->json([
                    'message' => 'Produk tidak ditemukan'
                ]);
            }

            TransaksiKeluar::create([
                'produk_id' => $produk->id,
                'jumlah' => $jumlah
            ]); 

            $stok = new StokController();
            $stok->stock_sub($request->produk_id,$request->jumlah);

            return response()
            ->json([
                'message' => 'Berhasil melakukan transaksi'
            ]);
       } 
       catch (ValidationException $th){
        Log::error($th->getMessage(),[$th]);
        return response()
        ->json([
            'message' => 'Parameter invalid'
        ],400);
       }
       catch (\Throwable $th) {
        Log::error($th->getMessage(),[$th]);
        return response()
        ->json([
            'message' => 'Gagal melakukan transaksi'
        ],500);
       }

    }
}
