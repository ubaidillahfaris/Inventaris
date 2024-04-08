<?php

namespace App\Http\Controllers;

use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TransaksiMasukController extends Controller
{
    public function createTransaksi(Request $request){
        try {
            
            $request->validate([
                'produk_id' => 'required',
                'jumlah' => 'required',
                'exp_date' => 'nullable',
                'label_rak' => 'nullable'
            ]);

            // create transaksi
            $transaksi_masuk = $this->store([
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah,
                'exp_date' => $request->exp_date
            ]);

            // pendataan tempat penyimpanan
            if (isset($request->label_rak)) {
                $storageLocationController = new StorageLocationController();
                $requestData = new Request([
                    'produk_id' => $request->produk_id,
                    'transaksi_masuk_id' => $transaksi_masuk->id,
                    'label' => $request->label_rak,
                ]);

                $storageLocationController->store($requestData);
            }

            return response()
            ->json([
                'message' => 'Berhasil melakukan transaksi'
            ]);
        } 
        catch (ValidationException $th){
            Log::error($th->getMessage(),[$th]);
            return response()
            ->json([
                'message' => 'Gagal melakukan transaksi'
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

    public function store(array $transaksi){
        try {
            return TransaksiMasuk::create($transaksi);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
