<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FamilyCard;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(FamilyCard $familyCard)
    {
        $users = $familyCard->users; // Mengambil semua user yang terkait dengan FamilyCard
        return view('warga.user', compact('users', 'familyCard'));
    }

    public function store(Request $request, $familyCardId)
    {
        $familyCard = \App\Models\FamilyCard::find($familyCardId);
        if (!$familyCard) {
            return redirect()->back()->withErrors(['familyCard' => 'Family Card not found']);
        }

        try {
            $request->validate([
                'name' => 'required|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'nik' => 'required|unique:users,nik|digits:16',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir' => 'required',
                'jenis_pekerjaan' => 'required',
                'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai',
                'status_hubungan_keluarga' => 'required|in:kepala_keluarga,istri,anak',
                'password' => 'required|min:6',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $user = new User();
        $user->family_card_id = $familyCard->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nik = $request->nik;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->jenis_pekerjaan = $request->jenis_pekerjaan;
        $user->golongan_darah = $request->golongan_darah;
        $user->status_perkawinan = $request->status_perkawinan;
        $user->tanggal_perkawinan_atau_perceraian = $request->tanggal_perkawinan_atau_perceraian;
        $user->status_hubungan_keluarga = $request->status_hubungan_keluarga;
        $user->password = bcrypt($request->password); // Enkripsi password
        $user->save();

        return redirect()->route('user.index', $familyCard->id)->with('success', 'Anggota Keluarga berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('warga.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'required|unique:users,nik,' . $user->id . '|digits:16',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required',
            'jenis_pekerjaan' => 'required',
            'golongan_darah' => 'nullable',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai',
            'status_hubungan_keluarga' => 'required|in:kepala_keluarga,istri,anak',
        ]);

        $user->update($request->all());
        return redirect()->route('user.index', $user->family_card_id)->with('success', 'Anggota Keluarga berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index', $user->family_card_id)->with('success', 'Anggota Keluarga berhasil dihapus');
    }
}
