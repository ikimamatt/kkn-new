<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kegiatan; 
use App\Models\Absensi; 


class KegiatanController extends Controller
{
    public function ListKegiatan()
    {
        $kegiatan = Kegiatan::all();
        return view('kegiatan.ListKegiatan', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string'
        ]);

        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'dokumentasi' => json_encode([]) 
        ]);


        return redirect()->route('kegiatan.list')->with('success', 'Kegiatan berhasil ditambahkan!');

    }

    //method untuk mengupload gambar
    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $kegiatan = Kegiatan::findOrFail($id);
        $path = $request->file('foto')->store('dokumentasi', 'public');
    
        $dokumentasi = $kegiatan->dokumentasi ? json_decode($kegiatan->dokumentasi, true) : [];
        $dokumentasi[] = $path;
    
        $kegiatan->update([
            'dokumentasi' => json_encode($dokumentasi),
        ]);
    
        return redirect()->route('kegiatan.list')->with('success', 'Foto berhasil diupload!');
    }
    

    public function absensi()
    {
        $kegiatanList = Kegiatan::all();
        return view('kegiatan.absensi', compact('kegiatanList'));
    }
    
    public function absensiById($id)
    {
        $kegiatanList = Kegiatan::all();
        $kegiatan = Kegiatan::findOrFail($id);
        $absensi = Absensi::where('kegiatan_id', $id)->get();
        return view('kegiatan.absensi', compact('kegiatanList', 'kegiatan', 'absensi'));
    }
    
    public function simpanAbsensi(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_hp' => 'required',
            'status_kehadiran' => 'required|in:Hadir,Tidak Hadir'
        ]);
    
        Absensi::create([
            'kegiatan_id' => $id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nomor_hp' => $request->nomor_hp,
            'status_kehadiran' => $request->status_kehadiran,
        ]);
    
        return redirect()->back()->with('success', 'Data absensi berhasil disimpan');
    }

}
