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
        Schema::table('transaksi_sampah', function (Blueprint $table) {
            $table->foreignId('kategori_sampah_id')->nullable()->change();
            $table->decimal('berat_kg', 10, 2)->nullable()->change();
            $table->decimal('harga_per_kg', 12, 2)->nullable()->change();
            $table->decimal('total_harga', 14, 2)->nullable()->change();
            $table->decimal('co2_tersimpan', 12, 3)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_sampah', function (Blueprint $table) {
            $table->foreignId('kategori_sampah_id')->nullable(false)->change();
            $table->decimal('berat_kg', 10, 2)->nullable(false)->change();
            $table->decimal('harga_per_kg', 12, 2)->nullable(false)->change();
            $table->decimal('total_harga', 14, 2)->nullable(false)->change();
            $table->decimal('co2_tersimpan', 12, 3)->nullable(false)->change();
        });
    }
};
