<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyCard extends Model
{
    use HasFactory;

    protected $fillable = ['kk_number', 'house_id', 'kk_photo'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
