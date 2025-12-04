<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arus_kas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karang_taruna_id')->constrained('karang_taruna')->onDelete('cascade');
            $table->foreignId('kategori_keuangan_id')->constrained('kategori_keuangan');
            $table->foreignId('penjualan_sampah_id')->nullable()->constrained('penjualan_sampah');
            $table->enum('jenis_transaksi', ['masuk', 'keluar']);
            $table->decimal('jumlah', 14, 2);
            $table->date('tanggal_transaksi');
            $table->text('deskripsi')->nullable();
            $table->string('bukti_transaksi')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arus_kas');
    }
};