<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArusKas extends Model
{
    protected $table = 'arus_kas';

    protected $fillable = [
        'karang_taruna_id',
        'kategori_keuangan_id',
        'jenis_transaksi',
        'jumlah',
        'tanggal_transaksi',
        'deskripsi',
        'created_by',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'jumlah' => 'decimal:2',
    ];

    // Relationships
    public function karangTaruna(): BelongsTo
    {
        return $this->belongsTo(KarangTaruna::class);
    }

    public function kategoriKeuangan(): BelongsTo
    {
        return $this->belongsTo(KategoriKeuangan::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
