<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karang_taruna_id')->constrained('karang_taruna')->onDelete('cascade');
            $table->string('nama_lengkap', 150);
            $table->string('nik', 20)->unique();
            $table->text('alamat')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('no_telepon', 30)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};