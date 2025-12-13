<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKeuangan extends Model
{
    use HasFactory;
    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'nama_kategori',
        'jenis',
        'deskripsi',
    ];

    // Relationships
    public function arusKas(): HasMany
    {
        return $this->hasMany(ArusKas::class);
    }
}