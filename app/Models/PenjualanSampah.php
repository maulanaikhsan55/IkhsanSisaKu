<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanSampah extends Model
{
    protected $table = 'penjualan_sampah';

    protected $fillable = [
        'karang_taruna_id',
        'tanggal_setor',
        'total_uang_diterima',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_setor' => 'datetime',
    ];

    public function karangTaruna(): BelongsTo
    {
        return $this->belongsTo(KarangTaruna::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
