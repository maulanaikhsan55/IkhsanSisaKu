<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_sampah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karang_taruna_id')->constrained('karang_taruna')->onDelete('cascade');
            $table->dateTime('tanggal_setor');
            $table->decimal('total_uang_diterima', 14, 2);
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_sampah');
    }
};
