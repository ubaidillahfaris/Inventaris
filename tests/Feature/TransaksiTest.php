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
        $produk = Produk::find(2);
        $response = $this->actingAs($user)->post(route('transaksi_masuk.create'),[
            'produk_id' => $produk->id,
            'jumlah' => 10,
            'exp_date' => '2023-04-10',
            'label_rak' => '2A',
        ]);
        $response->assertStatus(200);
    }

    public function test_transaksi_keluar(): void{
        $user = User::first();
        $produk = Produk::first();
        $request = $this->actingAs($user)->post(route('transaksi_keluar.create',[
            'produk_id' => $produk->id,
            'jumlah' => 10
        ]));
        $request->assertStatus(200);
    }

    public function test_show_masuk() {
        $user = User::first();
        $response = $this->actingAs($user)->get(route('transaksi_masuk.show',[
            'start_date'=>'2024-03-01',
            'end_date'=>'2024-04-30',
        ]));
        $response->assertStatus(200);
    }

    public function test_overview_masuk(){
        $user = User::first();
        $response = $this->actingAs($user)->get(route('transaksi_masuk.show_overview',[
            'month'=> 4,
        ]));
        $response->assertStatus(200);
    }

    public function transaksi_keluar():void {

    }
}
