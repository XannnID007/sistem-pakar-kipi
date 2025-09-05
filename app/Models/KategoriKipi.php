<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKipi extends Model
{
    protected $table = 'kategori_kipis';

    protected $fillable = ['kode', 'jenis_kipi', 'saran'];
}
