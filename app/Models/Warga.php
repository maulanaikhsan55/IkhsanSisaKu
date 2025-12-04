<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    protected $table = 'warga';

    protected $fillable = [
        'karang_taruna_id',
        'nama',
        'alamat',
        'no_telepon',
    ];

    // Relationships
    public function karangTaruna(): BelongsTo
    {
        return $this->belongsTo(KarangTaruna::class);
    }

    public function transaksiSampah(): HasMany
    {
        return $this->hasMany(TransaksiSampah::class);
    }
}