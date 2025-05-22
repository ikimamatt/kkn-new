<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'nik', 'tanggal_lahir', 'jenis_kelamin', 'tempat_lahir',
        'jenis_pekerjaan', 'golongan_darah', 'status_perkawinan', 'status_hubungan_keluarga', 'family_card_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function familyCard()
    {
        return $this->belongsTo(FamilyCard::class, 'family_card_id');
    }
}
