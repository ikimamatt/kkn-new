<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 'nik', 'tanggal_lahir',
        'jenis_kelamin', 'tempat_lahir', 'jenis_pekerjaan', 'golongan_darah',
        'status_perkawinan', 'tanggal_perkawinan_atau_perceraian', 'status_hubungan_keluarga'
    ];

    // Relasi ke Kartu Keluarga
    public function familyCards()
    {
        return $this->belongsToMany(FamilyCard::class);
    }
}
