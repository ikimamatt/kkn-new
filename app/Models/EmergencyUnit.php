<?php
// app/Models/EmergencyUnit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyUnit extends Model
{
    use HasFactory;

    protected $fillable = ['unit_name'];

    public function numbers()
    {
        return $this->hasMany(EmergencyNumber::class);
    }
}
