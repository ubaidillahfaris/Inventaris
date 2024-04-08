<?php

namespace App\Http\Controllers;

use App\Http\Requests\Satuan\CreateSatuanRequest;
use App\Http\Requests\Satuan\FindRequest;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;

class ProdukController extends Controller
{

    public function createProduk(Request $request){

        try {
            $request->validate([
                'name' => 'required',
                'reg' => 'nullable',
                'satuan' => 'required'
            ]);


            $this->store($request);
        } 
        catch (ValidationException $th){
            Log::error($th->getMessage(), [$th]);
            return response()
            ->json([
                'message' => 'Gagal membuat produk',
            ],400);
        }
        catch (\Throwable $th) {
            Log::error($th->getMessage(), [$th]);
            return response()
            ->json([
                'message' => 'Gagal membuat produk',
            ],500);
        }
    }

    public function store(Request $request){
        try {

            $satuanController = new SatuanController;

            $findRequest = new FindRequest();
            $createRequest = new CreateSatuanRequest();

            $findRequest->merge(['name' => $request->satuan]);
            $createRequest->merge(['name' => $request->satuan]);
            $satuan = $satuanController->find($findRequest);
            if (!isset($satuan)) {
               $satuan =  $satuanController->store($createRequest);
            }

            $produk = Produk::create([
                'uuid' => Uuid::uuid4(),
                'name' => $request->name,
                'reg' => $request->reg,
                'satuan_id' => $satuan->id,
            ]);

            return $produk;
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), [$th]);
            throw $th;
        }
    }
}
