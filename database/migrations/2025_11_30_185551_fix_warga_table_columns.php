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
        Schema::table('warga', function (Blueprint $table) {
            if (Schema::hasColumn('warga', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('warga', 'rt')) {
                $table->dropColumn('rt');
            }
            if (Schema::hasColumn('warga', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('warga', 'nama_lengkap') && !Schema::hasColumn('warga', 'nama')) {
                $table->renameColumn('nama_lengkap', 'nama');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            if (Schema::hasColumn('warga', 'nama') && !Schema::hasColumn('warga', 'nama_lengkap')) {
                $table->renameColumn('nama', 'nama_lengkap');
            }
            if (!Schema::hasColumn('warga', 'rt')) {
                $table->string('rt', 10)->nullable();
            }
            if (!Schema::hasColumn('warga', 'status')) {
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            }
            if (!Schema::hasColumn('warga', 'nik')) {
                $table->string('nik', 20)->unique();
            }
        });
    }
};
