<?php

namespace Tests\Feature;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransaksiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_transaksi_masuk(): void
    {
        $user = User::first();
        $produk = Produk::first();
        $response = $this->actingAs($user)->post(route('transaksi_masuk.create'),[
            'produk_id' => $produk->id,
            'jumlah' => 10,
            'exp_date' => '2023-04-10',
            'label_rak' => '2A',
        ]);
        $response->assertStatus(200);
    }

    public function transaksi_keluar():void {

    }
}
