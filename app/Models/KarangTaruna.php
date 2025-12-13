<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KarangTaruna extends Model
{
    use HasFactory;
    protected $table = 'karang_taruna';

    protected $fillable = [
        'user_id',
        'nama_karang_taruna',
        'nama_lengkap',
        'no_telp',
        'rw',
        'status',
    ];

    protected $casts = [
        //
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function warga(): HasMany
    {
        return $this->hasMany(Warga::class);
    }

    public function transaksiSampah(): HasMany
    {
        return $this->hasMany(TransaksiSampah::class);
    }

    public function arusKas(): HasMany
    {
        return $this->hasMany(ArusKas::class);
    }

    public function penjualanSampah(): HasMany
    {
        return $this->hasMany(PenjualanSampah::class);
    }
}
