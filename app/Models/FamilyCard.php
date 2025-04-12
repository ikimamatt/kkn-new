<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyCard extends Model
{
    protected $fillable = ['kk_number'];

    // Relasi ke Rumah
    public function house()
    {
        return $this->belongsTo(House::class);
    }

    // Relasi ke User
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
