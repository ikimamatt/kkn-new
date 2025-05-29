<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Absensi; 
use Illuminate\Support\Facades\Storage; 

class KegiatanController extends Controller
{
    public function ListKegiatan()
    {
        $kegiatan = Kegiatan::latest()->paginate(5);
        return view('kegiatan.ListKegiatan', compact('kegiatan'));
    }

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
                    $path = $file->store('dokumentasi', 'public');
                    $dokumentasiPaths[] = $path;
                }
            }
        }

        $absensiPath = null;
        if ($request->hasFile('absensi')) {
            if ($request->file('absensi')->isValid()) {
                $absensiPath = $request->file('absensi')->store('absensi', 'public');
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

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.EditKegiatan', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'dokumentasi_baru.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'absensi_baru' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);

        $existingDokumentasi = json_decode($kegiatan->dokumentasi ?? '[]', true);
        $newDocumentationPaths = [];

        if ($request->hasFile('dokumentasi_baru')) {
            foreach ($request->file('dokumentasi_baru') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('dokumentasi', 'public');
                    $newDocumentationPaths[] = $path;
                }
            }
        }
        $updatedDokumentasi = array_filter(array_merge($existingDokumentasi, $newDocumentationPaths));

        $updatedAbsensi = json_decode($kegiatan->absensi ?? '[]', true);
        $newAbsensiPath = null;

        if ($request->hasFile('absensi_baru')) {
            if (!empty($updatedAbsensi) && Storage::disk('public')->exists($updatedAbsensi[0])) {
                Storage::disk('public')->delete($updatedAbsensi[0]);
            }

            if ($request->file('absensi_baru')->isValid()) {
                $newAbsensiPath = $request->file('absensi_baru')->store('absensi', 'public');
            }
            $updatedAbsensi = $newAbsensiPath ? [$newAbsensiPath] : [];
        }

        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'dokumentasi' => json_encode($updatedDokumentasi),
            'absensi' => json_encode($updatedAbsensi),
        ]);

        return redirect()->route('kegiatan.list')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        foreach (json_decode($kegiatan->dokumentasi ?? '[]', true) as $file) {
            Storage::disk('public')->delete($file);
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
