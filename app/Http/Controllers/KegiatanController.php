<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ListKegiatan()
    {
        $kegiatan = Kegiatan::latest()->paginate(5);
        return view('kegiatan.ListKegiatan', compact('kegiatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'absensi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $dokumentasiPaths = [];
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('kegiatan_dokumentasi', 'public');
                    $dokumentasiPaths[] = $path;
                }
            }
        }

        $absensiPath = null;
        if ($request->hasFile('absensi')) {
            if ($request->file('absensi')->isValid()) {
                $absensiPath = $request->file('absensi')->store('kegiatan_absensi', 'public');
            }
        }

        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'dokumentasi' => json_encode($dokumentasiPaths),
            'absensi' => json_encode($absensiPath ? [$absensiPath] : []),
        ]);

        return redirect()->route('kegiatan.list')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.EditKegiatan', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'dokumentasi_baru.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'absensi_baru' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'removed_dokumentasi_paths' => 'nullable|string',
            'removed_absensi_paths' => 'nullable|string',
        ]);

        $currentDokumentasi = json_decode($kegiatan->dokumentasi ?? '[]', true);
        $currentAbsensi = json_decode($kegiatan->absensi ?? '[]', true);

        $removedDokumentasiPaths = $request->input('removed_dokumentasi_paths') ? json_decode($request->input('removed_dokumentasi_paths'), true) : [];
        $removedAbsensiPaths = $request->input('removed_absensi_paths') ? json_decode($request->input('removed_absensi_paths'), true) : [];

        foreach ($removedDokumentasiPaths as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $currentDokumentasi = array_diff($currentDokumentasi, [$path]);
        }

        foreach ($removedAbsensiPaths as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $currentAbsensi = array_diff($currentAbsensi, [$path]);
        }

        $newDocumentationPaths = [];
        if ($request->hasFile('dokumentasi_baru')) {
            foreach ($request->file('dokumentasi_baru') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('kegiatan_dokumentasi', 'public');
                    $newDocumentationPaths[] = $path;
                }
            }
        }

        $newAbsensiPath = null;
        if ($request->hasFile('absensi_baru')) {
            if (!empty($currentAbsensi) && Storage::disk('public')->exists($currentAbsensi[0])) {
                Storage::disk('public')->delete($currentAbsensi[0]);
            }
            if ($request->file('absensi_baru')->isValid()) {
                $newAbsensiPath = $request->file('absensi_baru')->store('kegiatan_absensi', 'public');
            }
            $currentAbsensi = $newAbsensiPath ? [$newAbsensiPath] : [];
        }

        $finalDokumentasi = array_merge($currentDokumentasi, $newDocumentationPaths);
        $finalDokumentasi = array_values($finalDokumentasi);

        $finalAbsensi = array_values($currentAbsensi);

        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'dokumentasi' => json_encode($finalDokumentasi),
            'absensi' => json_encode($finalAbsensi),
        ]);

        return redirect()->route('kegiatan.list')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        foreach (json_decode($kegiatan->dokumentasi ?? '[]', true) as $file) {
            if (Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        foreach (json_decode($kegiatan->absensi ?? '[]', true) as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.list')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
