<?php
// database/seeders/EmergencySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmergencyUnit;
use App\Models\EmergencyNumber;

class EmergencySeeder extends Seeder
{
    public function run()
    {
        // Membuat data unit darurat
        $units = EmergencyUnit::create([
            'unit_name' => 'Pemadam Kebakaran',
        ]);
        $units = EmergencyUnit::create([
            'unit_name' => 'Polisi',
        ]);
        $units = EmergencyUnit::create([
            'unit_name' => 'Rumah Sakit',
        ]);

        // Menambahkan nomor darurat untuk unit Pemadam Kebakaran
        EmergencyNumber::create([
            'emergency_unit_id' => 1,
            'location' => 'Balikpapan Utara',
            'phone_number' => '090898',
        ]);
        EmergencyNumber::create([
            'emergency_unit_id' => 1,
            'location' => 'Balikpapan Timur',
            'phone_number' => '090899',
        ]);

        // Menambahkan nomor darurat untuk unit Polisi
        EmergencyNumber::create([
            'emergency_unit_id' => 2,
            'location' => 'Balikpapan Barat',
            'phone_number' => '090900',
        ]);
        EmergencyNumber::create([
            'emergency_unit_id' => 2,
            'location' => 'Balikpapan Selatan',
            'phone_number' => '090901',
        ]);

        // Menambahkan nomor darurat untuk unit Rumah Sakit
        EmergencyNumber::create([
            'emergency_unit_id' => 3,
            'location' => 'Balikpapan Kota',
            'phone_number' => '090902',
        ]);
        EmergencyNumber::create([
            'emergency_unit_id' => 3,
            'location' => 'Balikpapan Timur',
            'phone_number' => '090903',
        ]);
    }
}
