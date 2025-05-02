<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Block;
use App\Models\House;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua blok
        $blocks = Block::all();

        // Loop untuk setiap blok
        foreach ($blocks as $block) {
            // Buat 20 rumah untuk setiap blok
            for ($i = 1; $i <= 20; $i++) {
                House::create([
                    'block_id' => $block->id,  // Menyambungkan rumah dengan blok
                    'house_number' => $block->name . '-' . $i,  // Nomor rumah berdasarkan blok dan nomor rumah (F1-1, F1-2, ...)
                ]);
            }
        }
    }
}
