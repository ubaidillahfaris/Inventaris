<?php

namespace App\Http\Controllers;

use App\Models\StokOpname;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class StokOpnameController extends Controller
{

    public function show(Request $request){

        $start_date = $request->start_date??Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date = $request->end_date??Carbon::now()->lastOfMonth()->format('Y-m-d');

        StokOpname::where('periode_start','>=',$start_date)
        ->where('periode_end','<=',$end_date)
        ->paginate();
    }

    public function create(Request $request){
        try {

            $request->validate([
                'produk_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'stok_awal' => 'required',
                'stok_fisik' => 'required',
                'keterangan' => 'nullable'
            ]);

            $stokAkhir = $this->perhitunganStokAkhir($request->stok_awal, $request->stok_fisik);
            $selisih = $this->perhitunganSelisih($request->stok_awal, $request->stok_fisik);
            StokOpname::updateOrCreate(
                [
                    'produk_id' => $request->produk_id,
                    'periode_start' => $request->start_date,
                    'periode_end' => $request->end_date,
                ],
                [
                    'stok_awal' => $request->stok_awal,
                    'stok_fisik' => $request->stok_fisik,
                    'stok_akhir' => $stokAkhir,
                    'selisih' => $selisih,
                    'keterangan' => $request->keterangan
                ]
            );

            $stokController = new StokController();
            $stokController->stok_update($request->produk_id, $stokAkhir);
            return response()
            ->json([
                'message' => 'Berhasil stokopname'
            ]);
        } 
        catch (ValidationException $th){
            Log::error($th->getMessage(), [$th]);
            return response()
            ->json([
                'message' => 'Gagal stokopname',
                'description' => $th->getMessage()
            ],400);
        }
        catch (\Throwable $th) {
            Log::error($th->getMessage(), [$th]);
            return response()
            ->json([
                'message' => 'Gagal stokopname',
                'description' => $th->getMessage()
            ],500);
        }
    }

    public function perhitunganStokAkhir(int $stokAwal = 0, int $stokFisik = 0){
        return $stokAwal + $this->perhitunganSelisih($stokAwal, $stokFisik);
    }

    public function perhitunganSelisih(int $stokAwal = 0, int $stokFisik = 0){
        return $stokFisik - $stokAwal;
    }
}
