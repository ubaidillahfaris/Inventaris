<?php

namespace App\Http\Controllers;

use App\Models\TransaksiMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TransaksiMasukController extends Controller
{
    public function show(Request $request){
        try {
            $search = $request->search??null;
            $startDate = $request->start_date??null;
            $endDate = $request->end_date??null;
            $length = $request->length??10;

            $transaksiMasuk = TransaksiMasuk::when($startDate && $endDate, function($sub) use($startDate, $endDate){
                $sub->whereBetween('created_at',[$startDate, $endDate]);
            })
            ->with('produk')
            ->when($search, function($sub) use($search){
                $sub->whereHas('produk',function($subProduk) use($search){
                    $subProduk->where('name','LIKE',"%$search%");
                });
            })->paginate($length);

            return response()->json($transaksiMasuk);

        } catch (\Throwable $th) {
            Log::error($th->getMessage(),[$th]);
            return response()
            ->json([
                'message' => 'gagal mengambil data'
            ],500);
        }
    }

    public function showOverview(Request $request){
        try {
            $now = Carbon::now();
            $month = $request->month??$now->month();
            $search = $request->search??null;
            $length = $request->length??10;

            $transaksiMasuk = TransaksiMasuk::select('produk_id',DB::raw('SUM(jumlah) as jumlah'))
            ->whereMonth('created_at',$month)
            ->with('produk')
            ->when($search, function($sub) use($search){
                $sub->whereHas('produk',function($subProduk) use($search){
                    $subProduk->where('name','LIKE',"%$search%");
                });
            })
            ->groupBy('produk_id','jumlah')
            ->paginate($length);
            return response()->json($transaksiMasuk);
        } catch (\Throwable $th) {
            Log::error($th->getMessage(),[$th]);
            return response()
            ->json([
                'message' => 'gagal mengambil data'
            ],500);
        }

    }

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
