<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\KarangTaruna;
use App\Models\Warga;
use App\Models\KategoriSampah;
use App\Models\KonversiDampak;
use App\Models\TransaksiSampahItem;

class TransaksiSampah extends Model
{
    protected $table = 'transaksi_sampah';

    protected $fillable = [
        'karang_taruna_id',
        'warga_id',
        'kategori_sampah_id',
        'berat_kg',
        'harga_per_kg',
        'total_harga',
        'harga_pembayaran',
        'co2_tersimpan',
        'status_penjualan',
        'tanggal_transaksi',
        'tanggal_terjual',
        'catatan',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'tanggal_terjual' => 'datetime',
        'berat_kg' => 'decimal:2',
        'harga_per_kg' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'harga_pembayaran' => 'decimal:2',
        'co2_tersimpan' => 'decimal:3',
    ];

    public function karangTaruna(): BelongsTo
    {
        return $this->belongsTo(KarangTaruna::class);
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    public function kategoriSampah(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransaksiSampahItem::class);
    }

    public function getTotalBeratAttribute()
    {
        if ($this->items()->exists()) {
            return $this->items()->sum('berat_kg');
        }
        return $this->berat_kg ?? 0;
    }

    public function getTotalHargaFromItemsAttribute()
    {
        if ($this->items()->exists()) {
            return $this->items()->sum('total_harga');
        }
        return $this->total_harga ?? 0;
    }

    public function getTotalCO2Attribute()
    {
        if ($this->items()->exists()) {
            return $this->items()->sum('co2_tersimpan');
        }
        return $this->co2_tersimpan ?? 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($transaksi) {
            if ($transaksi->kategori_sampah_id && $transaksi->berat_kg) {
                $konversi = KonversiDampak::where('kategori_sampah_id', $transaksi->kategori_sampah_id)->first();
                if ($konversi) {
                    $transaksi->co2_tersimpan = round($transaksi->berat_kg * $konversi->co2_per_kg, 3);
                }
            }
        });
    }
}