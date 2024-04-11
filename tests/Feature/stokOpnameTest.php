<?php

namespace Tests\Feature;

use App\Models\Produk;
use App\Models\Stok;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class stokOpnameTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create(): void
    {

        $user = User::first();
        $produk = Produk::first();
        $stok = Stok::where('produk_id',$produk->id)
        ->first();
        
        $response = $this->actingAs($user)->post(route('stok_opname.create'),[
            'produk_id' => $produk->id,
            'start_date' => '2024-04-01',
            'end_date' => '2024-04-30',
            'stok_awal' => $stok->jumlah??0,
            'stok_fisik' => 8,
            'keterangan' => null
        ]);

        $response->assertStatus(200);
    }
}
