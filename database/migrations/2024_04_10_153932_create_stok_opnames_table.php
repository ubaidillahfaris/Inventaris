<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->id();
            $table->date('periode_start');
            $table->date('periode_end');
            $table->unsignedBigInteger('produk_id');
            $table->bigInteger('stok_awal');
            $table->bigInteger('stok_fisik');
            $table->bigInteger('stok_akhir');
            $table->bigInteger('selisih');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opnames');
    }
};
