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
        Schema::table('karang_taruna', function (Blueprint $table) {
            $table->string('nama_lengkap', 255)->nullable()->after('nama_karang_taruna');
            $table->string('no_telp', 20)->nullable()->after('nama_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karang_taruna', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'no_telp']);
        });
    }
};
