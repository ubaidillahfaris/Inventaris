<?php

namespace App\Http\Controllers;

use App\Models\StorageLocation;
use Illuminate\Http\Request;

class StorageLocationController extends Controller
{
    public function store(Request $request){
        try {
            $request->validate([
                'produk_id' => 'required',
                'transaksi_masuk_id' => 'required',
                'label' => 'nullable'
            ]);

            $data = $request->all();
            $data['barcode_path'] = 'barcode path'; // ganti kode ini ke file barcode yang digenerate
            StorageLocation::create($data);
        } catch (\Throwable $th) {
            
        }
    }
}
