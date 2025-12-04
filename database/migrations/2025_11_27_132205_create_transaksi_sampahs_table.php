<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_sampah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karang_taruna_id')->constrained('karang_taruna')->onDelete('cascade');
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->foreignId('kategori_sampah_id')->constrained('kategori_sampah');
            $table->decimal('berat_kg', 10, 2);
            $table->decimal('harga_per_kg', 12, 2);
            $table->decimal('total_harga', 14, 2);
            $table->decimal('co2_tersimpan', 12, 3)->nullable();
            $table->enum('status_penjualan', ['belum_terjual', 'sudah_terjual'])->default('belum_terjual');
            $table->dateTime('tanggal_transaksi')->useCurrent();
            $table->dateTime('tanggal_terjual')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_sampah');
    }
};