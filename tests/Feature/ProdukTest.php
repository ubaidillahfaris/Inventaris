<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProdukTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->post(route('produk.create'),[
            'name' => 'Produk 2',
            'reg' => 'Reg 2',
            'satuan' => 'Box'
        ]);
        $response->assertStatus(200);
    }
}
