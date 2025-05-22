<?php
namespace App\Http\Controllers;

use App\Models\House;
use App\Models\FamilyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FamilyCardController extends Controller
{
    // Menampilkan daftar Kartu Keluarga berdasarkan rumah
    public function index(House $house)
    {
        $familyCards = $house->familyCards;  // Ambil semua kartu keluarga terkait rumah
        return view('warga.familycard', compact('familyCards', 'house'));
    }

    // Menyimpan Kartu Keluarga baru
    public function store(Request $request, House $house)
    {
        $request->validate([
            'kk_number' => 'required|unique:family_cards,kk_number',  // Validasi Nomor Kartu Keluarga
            'kk_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi foto Kartu Keluarga
        ]);

        // Proses upload foto jika ada
        $kkPhotoPath = null;
        if ($request->hasFile('kk_photo')) {
            $kkPhotoPath = $request->file('kk_photo')->store('family_card_photos', 'public');
        }

        // Menyimpan data Kartu Keluarga
        $house->familyCards()->create([
            'kk_number' => $request->kk_number,
            'kk_photo' => $kkPhotoPath,
        ]);

        return redirect()->route('familyCard.index', $house->id)->with('success', 'Kartu Keluarga berhasil dibuat.');
    }

    // Memperbarui Kartu Keluarga
    public function update(Request $request, FamilyCard $familyCard)
    {
        $request->validate([
            'kk_number' => 'required|unique:family_cards,kk_number,' . $familyCard->id,
            'kk_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi foto Kartu Keluarga
        ]);

        // Proses upload foto jika ada
        if ($request->hasFile('kk_photo')) {
            // Hapus foto lama jika ada
            if ($familyCard->kk_photo) {
                Storage::delete('public/' . $familyCard->kk_photo);
            }

            // Upload foto baru
            $kkPhotoPath = $request->file('kk_photo')->store('family_card_photos', 'public');
            $familyCard->kk_photo = $kkPhotoPath;
        }

        // Memperbarui Kartu Keluarga
        $familyCard->update([
            'kk_number' => $request->kk_number,
        ]);

        return redirect()->route('familyCard.index', $familyCard->house_id)->with('success', 'Kartu Keluarga berhasil diperbarui.');
    }

    // Menghapus Kartu Keluarga
    public function destroy(FamilyCard $familyCard)
    {
        // Hapus foto jika ada
        if ($familyCard->kk_photo) {
            Storage::delete('public/' . $familyCard->kk_photo);
        }

        $familyCard->delete();
        return redirect()->route('familyCard.index', $familyCard->house_id)->with('success', 'Kartu Keluarga berhasil dihapus.');
    }
}
