<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = ['house_number', 'block_id']; // Pastikan block_id ada di sini

    // Relasi ke Block
    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    // Relasi ke Kartu Keluarga
    public function familyCards()
    {
        return $this->hasMany(FamilyCard::class);
    }
}
