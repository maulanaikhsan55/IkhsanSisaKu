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
        Schema::table('kategori_sampah', function (Blueprint $table) {
            $table->text('referensi')->nullable()->comment('Referensi/Notes CO2 dan sumber data');
            $table->text('sumber')->nullable()->comment('Sumber data referensi (IPCC, Kementan, dll)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_sampah', function (Blueprint $table) {
            $table->dropColumn(['referensi', 'sumber']);
        });
    }
};
