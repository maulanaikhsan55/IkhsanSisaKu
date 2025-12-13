<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KategoriSampah extends Model
{
    use HasFactory;
    protected $table = 'kategori_sampah';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'harga_per_kg',
        'tanggal_berlaku',
    ];

    protected $casts = [
        'harga_per_kg' => 'decimal:2',
        'tanggal_berlaku' => 'date',
    ];

    // Relationships
    public function konversiDampak(): HasOne
    {
        return $this->hasOne(KonversiDampak::class);
    }

    public function transaksiSampah(): HasMany
    {
        return $this->hasMany(TransaksiSampah::class);
    }
}