<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengetahuan extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sama dengan nama model dalam bentuk jamak)
    protected $table = 'pengetahuan';

    // Kolom yang dapat diisi
    protected $fillable = [
        'kode_aturan',
        'kode_kipi',
        'kode_gejala',
        'mb',
        'md',
    ];

    // Relasi ke tabel kategori_kipis
    public function kategoriKipi()
    {
        return $this->belongsTo(KategoriKipi::class, 'kode_kipi', 'kode');
    }

    // Relasi ke tabel gejalas
    public function gejala()
    {
        return $this->belongsTo(Gejala::class, 'kode_gejala', 'kode');
    }
}
