<?php

namespace App\Http\Controllers;

use App\Models\FamilyCard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan data anggota keluarga berdasarkan kartu keluarga
    public function index(FamilyCard $familyCard)
    {
        $users = $familyCard->users; // Ambil semua anggota keluarga yang terkait dengan kartu keluarga
        return view('warga.user', compact('users', 'familyCard'));
    }

    // Menampilkan form untuk membuat anggota keluarga baru
    public function create(FamilyCard $familyCard)
    {
        return view('warga.user.create', compact('familyCard'));
    }

    // Menyimpan anggota keluarga baru
    public function store(Request $request, FamilyCard $familyCard)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nik' => 'required|unique:users,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|string|max:255',
            'golongan_darah' => 'nullable|string|max:3',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai',
            'tanggal_perkawinan_atau_perceraian' => 'nullable|date',
            'status_hubungan_keluarga' => 'required|in:kepala_keluarga,istri,anak',
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Enkripsi password
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'golongan_darah' => $request->golongan_darah,
            'status_perkawinan' => $request->status_perkawinan,
            'tanggal_perkawinan_atau_perceraian' => $request->tanggal_perkawinan_atau_perceraian,
            'status_hubungan_keluarga' => $request->status_hubungan_keluarga,
        ]);

        // Menambahkan user ke kartu keluarga
        $familyCard->users()->attach($user->id);

        return redirect()->route('user.index', $familyCard->id)->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit anggota keluarga
    public function edit(User $user)
    {
        return view('warga.user.edit', compact('user'));
    }

    // Memperbarui data anggota keluarga
    public function update(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'required|unique:users,nik,' . $user->id,
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|string|max:255',
            'golongan_darah' => 'nullable|string|max:3',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai',
            'tanggal_perkawinan_atau_perceraian' => 'nullable|date',
            'status_hubungan_keluarga' => 'required|in:kepala_keluarga,istri,anak',
        ]);

        // Memperbarui data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'golongan_darah' => $request->golongan_darah,
            'status_perkawinan' => $request->status_perkawinan,
            'tanggal_perkawinan_atau_perceraian' => $request->tanggal_perkawinan_atau_perceraian,
            'status_hubungan_keluarga' => $request->status_hubungan_keluarga,
        ]);

        // Jika password diubah, kita update passwordnya
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('user.index', $user->familyCards->first()->id)->with('success', 'Data anggota keluarga berhasil diperbarui!');
    }

    // Menghapus anggota keluarga
    public function destroy(User $user)
    {
        $user->familyCards()->detach(); // Menghapus hubungan dengan kartu keluarga
        $user->delete(); // Menghapus data user

        return redirect()->route('user.index', $user->familyCards->first()->id)->with('success', 'Anggota keluarga berhasil dihapus!');
    }
}
