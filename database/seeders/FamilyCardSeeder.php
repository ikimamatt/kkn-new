<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;
use App\Models\FamilyCard;

class FamilyCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua rumah yang ada
        $houses = House::all();

        // Loop untuk setiap rumah
        foreach ($houses as $house) {
            // Generate nomor Kartu Keluarga (16 digit)
            $kkNumber = $this->generateKKNumber();

            // Buat Kartu Keluarga untuk setiap rumah
            FamilyCard::create([
                'house_id' => $house->id,  // Menyambungkan kartu keluarga dengan rumah
                'kk_number' => $kkNumber   // Nomor Kartu Keluarga
            ]);
        }
    }

    /**
     * Fungsi untuk menghasilkan nomor Kartu Keluarga (16 digit)
     *
     * @return string
     */
    private function generateKKNumber()
    {
        // Membuat nomor 16 digit secara acak
        return str_pad(rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }
}
