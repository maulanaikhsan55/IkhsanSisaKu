<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->dropColumn('nik');
            $table->dropColumn('status');
            $table->dropColumn('rt');
            $table->renameColumn('nama_lengkap', 'nama');
        });
    }

    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->renameColumn('nama', 'nama_lengkap');
            $table->string('rt', 10)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('nik', 20)->unique();
        });
    }
};
