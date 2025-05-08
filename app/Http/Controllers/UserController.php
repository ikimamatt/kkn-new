<?php

namespace App\Http\Controllers;

use App\Models\FamilyCard;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan daftar anggota keluarga berdasarkan Kartu Keluarga
    public function index(FamilyCard $familyCard)
    {
        // Mengambil anggota keluarga yang terhubung dengan Kartu Keluarga tertentu
        $users = $familyCard->users;

        // Menampilkan halaman dengan data anggota keluarga
        return view('warga.user', compact('users', 'familyCard'));
    }

    // Menampilkan form untuk menambah anggota keluarga baru
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
            'status_perkawinan' => 'in:belum_kawin,kawin,cerai',
            'status_hubungan_keluarga' => 'required|in:kepala_keluarga,istri,anak',
        ]);

        // Menyimpan anggota keluarga baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'golongan_darah' => $request->golongan_darah,
            'status_perkawinan' => $request->status_perkawinan,
            'status_hubungan_keluarga' => $request->status_hubungan_keluarga,
        ]);

        // Menambahkan user ke kartu keluarga
        $familyCard->users()->attach($user->id);

        // Redirect ke halaman anggota keluarga
        return redirect()->route('user.index', $familyCard->id)->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit anggota keluarga
    public function edit(User $user)
    {
        return view('warga.user.edit', compact('user'));
    }

    // Memperbarui anggota keluarga
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
            'status_hubungan_keluarga' => 'required|in:kepala_keluarga,istri,anak',
        ]);

        // Memperbarui data anggota keluarga
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
            'status_hubungan_keluarga' => $request->status_hubungan_keluarga,
        ]);

        // Jika password diubah
        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        // Redirect ke halaman anggota keluarga
        return redirect()->route('user.index', $user->familyCards->first()->id)->with('success', 'Data anggota keluarga berhasil diperbarui!');
    }

    // Menghapus anggota keluarga
    public function destroy(User $user)
    {
        // Menghapus anggota keluarga dari tabel pivot dan database
        $user->familyCards()->detach();
        $user->delete();

        // Redirect ke halaman anggota keluarga
        return redirect()->back()->with('success', 'Anggota keluarga berhasil dihapus!');
    }
}
