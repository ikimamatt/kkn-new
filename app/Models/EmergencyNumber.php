<?php
// app/Models/EmergencyNumber.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyNumber extends Model
{
    use HasFactory;

    protected $fillable = ['emergency_unit_id', 'location', 'phone_number'];

    public function unit()
    {
        return $this->belongsTo(EmergencyUnit::class);
    }
}
