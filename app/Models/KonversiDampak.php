<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KonversiDampak extends Model
{
    protected $table = 'konversi_dampak';

    protected $fillable = [
        'kategori_sampah_id',
        'co2_per_kg',
    ];

    protected $casts = [
        'co2_per_kg' => 'decimal:3',
    ];

    // Relationships
    public function kategoriSampah(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class);
    }
}