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
        Schema::create('transaksi_sampah_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_sampah_id')->constrained('transaksi_sampah')->onDelete('cascade');
            $table->foreignId('kategori_sampah_id')->constrained('kategori_sampah');
            $table->decimal('berat_kg', 10, 2);
            $table->decimal('harga_per_kg', 12, 2);
            $table->decimal('total_harga', 14, 2);
            $table->decimal('co2_tersimpan', 12, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_sampah_items');
    }
};
