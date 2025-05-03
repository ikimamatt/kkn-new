<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'deskripsi',
        'dokumentasi',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
