<?php

namespace App\Http\Controllers;

use App\Models\StorageLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

class StorageLocationController extends Controller
{
    public function store(Request $request){
        try {
            $request->validate([
                'produk_id' => 'required',
                'transaksi_masuk_id' => 'required',
                'label' => 'nullable'
            ]);
            $produkId = $this->formatNomor($request->produk_id);
            $data = $request->all();
            $dnsd = new DNS1D();
            Storage::put("public/barcode/$produkId.png",base64_decode($dnsd->getBarcodePNG($produkId, 'EAN13')));
            $data['barcode_path'] = "public/barcode/$produkId.png";
            StorageLocation::create($data);

        } catch (\Throwable $th) {
            Log::error($th->getMessage(),[$th]);
            throw $th;
        }
    }

    private function formatNomor($nomor) {
        return str_pad($nomor, 10, '0', STR_PAD_LEFT);
    }
}
