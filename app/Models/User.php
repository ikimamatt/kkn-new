<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nik', 'tanggal_lahir',
        'jenis_kelamin', 'tempat_lahir', 'jenis_pekerjaan', 'golongan_darah',
        'status_perkawinan', 'tanggal_perkawinan_atau_perceraian', 'status_hubungan_keluarga'
    ];



    protected $hidden = [
        'password', 'remember_token',
    ];

    public function familyCard()
    {
        return $this->belongsTo(familyCard::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
