<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
<<<<<<< HEAD
=======
    use Notifiable, HasFactory;

>>>>>>> 9a51217143ace09924a272c3bdcce982972b3f93
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'tempat_lahir',
        'jenis_pekerjaan',
        'golongan_darah',
        'status_perkawinan',
        'tanggal_perkawinan_atau_perceraian',
        'status_hubungan_keluarga'
    ];

<<<<<<< HEAD
    // Relasi ke Kartu Keluarga
    public function familyCards()
=======


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function familyCard()
>>>>>>> 9a51217143ace09924a272c3bdcce982972b3f93
    {
        return $this->belongsToMany(FamilyCard::class);
    }
}
