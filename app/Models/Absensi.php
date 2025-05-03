<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = ['kegiatan_id', 'nama', 'alamat', 'nomor_hp', 'status_kehadiran'];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
