<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiSampahItem extends Model
{
    protected $table = 'transaksi_sampah_items';

    protected $fillable = [
        'transaksi_sampah_id',
        'kategori_sampah_id',
        'berat_kg',
        'harga_per_kg',
        'total_harga',
        'co2_tersimpan',
    ];

    protected $casts = [
        'berat_kg' => 'decimal:2',
        'harga_per_kg' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'co2_tersimpan' => 'decimal:3',
    ];

    public function transaksiSampah(): BelongsTo
    {
        return $this->belongsTo(TransaksiSampah::class);
    }

    public function kategoriSampah(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $konversi = KonversiDampak::where('kategori_sampah_id', $item->kategori_sampah_id)->first();
            if ($konversi) {
                $item->co2_tersimpan = round($item->berat_kg * $konversi->co2_per_kg, 3);
            }
        });
    }
}
