<?php

namespace App\Http\Controllers;

use App\Http\Requests\Satuan\CreateSatuanRequest;
use App\Http\Requests\Satuan\FindRequest;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class SatuanController extends Controller
{

    public function store(CreateSatuanRequest $request){
        try {
        
            $satuan = Satuan::create([
                'uuid' => Uuid::uuid4(),
                'name' => $request->name
            ]);
            return $satuan;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function find(FindRequest $request){
        try {
            $name = $request->name;
            $satuan = Satuan::where('name','LIKE',"$name%")
            ->first();
            return $satuan;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
