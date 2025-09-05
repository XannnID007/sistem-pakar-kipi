<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKepala extends Model
{
    protected $table = 'laporan_kepalas';

    protected $fillable = [
        'file_path',
        'nama_file',
     
    ];

    protected $casts = [
        'periode' => 'date',
    ];
}
