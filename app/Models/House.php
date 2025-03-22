<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = ['block_id', 'house_number'];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function familyCard()
    {
        return $this->hasOne(FamilyCard::class);
    }
}
