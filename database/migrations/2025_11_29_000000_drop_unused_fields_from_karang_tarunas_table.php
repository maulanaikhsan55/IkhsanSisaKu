<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karang_taruna', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penanggung_jawab',
                'alamat',
                'no_telepon',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('karang_taruna', function (Blueprint $table) {
            $table->string('nama_penanggung_jawab', 150)->nullable()->after('nama_karang_taruna');
            $table->text('alamat')->nullable()->after('rw');
            $table->string('no_telepon', 30)->nullable()->after('alamat');
        });
    }
};
