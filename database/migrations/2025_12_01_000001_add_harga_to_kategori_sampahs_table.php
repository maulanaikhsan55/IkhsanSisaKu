<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_sampah', function (Blueprint $table) {
            $table->decimal('harga_per_kg', 12, 2)->nullable()->after('deskripsi');
            $table->date('tanggal_berlaku')->nullable()->after('harga_per_kg');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_sampah', function (Blueprint $table) {
            $table->dropColumn(['harga_per_kg', 'tanggal_berlaku']);
        });
    }
};
