<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['name'];

    // Relasi ke Rumah
    public function houses()
    {
        return $this->hasMany(House::class);
    }
}

