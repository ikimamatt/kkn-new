<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Block;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data blok F1 - F6
        $blocks = ['F1', 'F2', 'F3', 'F4', 'F5', 'F6'];

        // Menggunakan Model untuk menyimpan data
        foreach ($blocks as $blockName) {
            Block::create([
                'name' => $blockName
            ]);
        }
    }
}
