<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\FamilyCard;
use Illuminate\Http\Request;

class FamilyCardController extends Controller
{
    // Menampilkan daftar Kartu Keluarga berdasarkan rumah
    public function index(House $house)
    {
        $familyCards = $house->familyCards;  // Ambil semua kartu keluarga terkait rumah
        return view('warga.familycard', compact('familyCards', 'house'));
    }

    // Menampilkan form untuk membuat Kartu Keluarga
    public function create(House $house)
    {
        return view('warga.familyCard.create', compact('house'));
    }

    // Menyimpan Kartu Keluarga baru
    public function store(Request $request, House $house)
    {
        $request->validate([
            'kk_number' => 'required|unique:family_cards,kk_number',  // Validasi Nomor Kartu Keluarga
        ]);

        // Menyimpan data Kartu Keluarga
        $house->familyCards()->create([
            'kk_number' => $request->kk_number,
        ]);

        return redirect()->route('familyCard.index', $house->id)->with('success', 'Kartu Keluarga berhasil dibuat.');
    }

    // Menampilkan form untuk edit Kartu Keluarga
    public function edit(FamilyCard $familyCard)
    {
        return view('warga.familyCard.edit', compact('familyCard'));
    }

    // Memperbarui Kartu Keluarga
    public function update(Request $request, FamilyCard $familyCard)
    {
        $request->validate([
            'kk_number' => 'required|unique:family_cards,kk_number,' . $familyCard->id,
        ]);

        $familyCard->update([
            'kk_number' => $request->kk_number,
        ]);

        return redirect()->route('familyCard.index', $familyCard->house_id)->with('success', 'Kartu Keluarga berhasil diperbarui.');
    }

    // Menghapus Kartu Keluarga
    public function destroy(FamilyCard $familyCard)
    {
        $familyCard->delete();
        return redirect()->route('familyCard.index', $familyCard->house_id)->with('success', 'Kartu Keluarga berhasil dihapus.');
    }
}
