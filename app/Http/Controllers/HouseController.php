<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Block;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    // Menampilkan semua rumah berdasarkan blok
    public function index(Block $block)
    {
        // Mengambil semua rumah yang terkait dengan blok tertentu
        $houses = $block->houses;
        return view('warga.house', compact('block', 'houses'));
    }

    // Menyimpan rumah baru
    public function store(Request $request, Block $block)
    {
        $request->validate(['house_number' => 'required']);

        // Menyimpan rumah ke blok yang sesuai, pastikan block_id disertakan
        $house = $block->houses()->create([
            'house_number' => $request->house_number,  // house_number dari form
            'block_id' => $block->id  // Menambahkan block_id yang terkait dengan blok ini
        ]);

        return response()->json([
            'message' => 'Rumah berhasil ditambahkan!',
            'house' => $house
        ]);
    }

    // Menampilkan form untuk mengedit rumah
    public function edit(House $house)
    {
        return response()->json($house);
    }

    // Memperbarui data rumah
    public function update(Request $request, House $house)
    {
        $request->validate(['house_number' => 'required']);

        // Memperbarui rumah yang sesuai
        $house->update($request->all());

        return response()->json([
            'message' => 'Rumah berhasil diperbarui!',
            'house' => $house
        ]);
    }

    // Menghapus rumah
    public function destroy(House $house)
    {
        $house->delete();
        return response()->json([
            'message' => 'Rumah berhasil dihapus!'
        ]);
    }
}
