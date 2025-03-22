<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyCard extends Model
{
    protected $fillable = ['house_id', 'kk_number'];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
