<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karang_taruna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('nama_karang_taruna', 150);
            $table->string('nama_penanggung_jawab', 150)->nullable();
            $table->string('rw', 10)->unique();
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 30)->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karang_taruna');
    }
};