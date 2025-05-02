<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index($block_id)
{
    // Ambil blok berdasarkan ID
    $block = Block::findOrFail($block_id);  // Menggunakan findOrFail() untuk menangani blok yang tidak ada

    // Ambil rumah yang terkait dengan blok
    $houses = $block->houses;

    // Kirim blok dan rumah ke tampilan
    return view('warga.house', compact('houses', 'block'));
}// Kirim data blok dan rumah ke view


    // Menyimpan data rumah baru
    public function store(Request $request, Block $block)
    {

        $request->validate([
            'house_number' => 'required|unique:houses,house_number'
        ]);

        // Menyimpan rumah dengan menyertakan block_id
        $block->houses()->create([
            'house_number' => $request->house_number,  // Nomor rumah yang dikirimkan
        ]);

        return redirect()->route('house.index', $block->id);  // Redirect ke halaman daftar rumah
    }

    // Menampilkan form edit rumah
    public function edit(House $house)
    {
        return view('warga.house.edit', compact('house'));
    }

    // Memperbarui data rumah
    public function update(Request $request, House $house)
    {
        $request->validate([
            'house_number' => 'required|unique:houses,house_number,' . $house->id
        ]);

        $house->update($request->all());
        return redirect()->route('house.index', $house->block_id);
    }

    // Menghapus rumah
    public function destroy(House $house)
    {
        $house->delete();
        return redirect()->route('house.index', $house->block_id);
    }
}
