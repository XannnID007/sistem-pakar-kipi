<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatDiagnosa extends Model
{
    protected $table = 'riwayat_diagnosa';

    protected $fillable = [
        'user_id',
        'nama_ibu',
        'nama_anak',
        'jenis_kelamin',
        'tanggal_lahir',
        'usia_anak',
        'alamat',
        'jenis_vaksin',
        'tempat_imunisasi',
        'tanggal_imunisasi',
        'tanggal',
        'diagnosa',
        'nilai_cf',
        'saran',
        'gejala_dipilih',
    ];
}
