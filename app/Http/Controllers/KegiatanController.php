<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kegiatan; 
use App\Models\Absensi; 


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

    // Menampilkan form edit
public function edit($id)
{
    $kegiatan = Kegiatan::findOrFail($id);
    return view('kegiatan.EditKegiatan', compact('kegiatan'));
}

// Menyimpan hasil edit
public function update(Request $request, $id)
{
    $request->validate([
        'nama_kegiatan' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'deskripsi' => 'required|string'
    ]);

    $kegiatan = Kegiatan::findOrFail($id);
    $kegiatan->update([
        'nama_kegiatan' => $request->nama_kegiatan,
        'tanggal' => $request->tanggal,
        'deskripsi' => $request->deskripsi
    ]);

    return redirect()->route('kegiatan.list')->with('success', 'Kegiatan berhasil diperbarui!');
}

// Hapus kegiatan
public function destroy($id)
{
    $kegiatan = Kegiatan::findOrFail($id);

    // Hapus juga file dokumentasi & absensi jika ada (opsional)
    foreach (json_decode($kegiatan->dokumentasi ?? '[]', true) as $file) {
        \Storage::disk('public')->delete($file);
    }
    foreach (json_decode($kegiatan->absensi ?? '[]', true) as $file) {
        \Storage::disk('public')->delete($file);
    }

    $kegiatan->delete();

    return redirect()->route('kegiatan.list')->with('success', 'Kegiatan berhasil dihapus!');
}


    //method untuk mengupload gambar
    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        $kegiatan = Kegiatan::findOrFail($id);
    
        $existingDokumentasi = json_decode($kegiatan->dokumentasi ?? '[]', true);
        $newImages = [];
    
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('dokumentasi', 'public');
                    $newImages[] = $path;
                }
            }
        }
    
        $kegiatan->dokumentasi = json_encode(array_filter(array_merge($existingDokumentasi, $newImages)));
        $kegiatan->save();
    
        return redirect()->back()->with('success', 'Dokumentasi berhasil diunggah');
    }
    

    public function uploadAbsensi(Request $request, $id)
    {
        $request->validate([
            'foto_absensi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $kegiatan = Kegiatan::findOrFail($id);
    
        $fotoAbsensiPath = null;
        if ($request->file('foto_absensi')->isValid()) {
            $fotoAbsensiPath = $request->file('foto_absensi')->store('absensi', 'public');
        }
    
        $absensi = json_decode($kegiatan->absensi ?? '[]', true);
        $absensi = is_array($absensi) ? $absensi : [];
    
        $absensi[] = $fotoAbsensiPath;
    
        $kegiatan->update(['absensi' => json_encode($absensi)]);
    
        return redirect()->back()->with('success', 'Foto absensi berhasil diunggah!');
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
