@extends('layouts.vertical', ['title' => 'General Elements'])

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Absensi Kegiatan</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Kegiatan</a></li>
            <li class="breadcrumb-item active">Absensi Kegiatan</li>
        </ol>
    </div>
</div>

<!-- Pilih Kegiatan -->
<form action="{{ route('kegiatan.absensi') }}" method="GET" onsubmit="location.href='/kegiatan/' + document.getElementById('pilihKegiatan').value + '/absensi'; return false;">
    <div class="mb-3">
        <label for="pilihKegiatan" class="form-label">Pilih Kegiatan</label>
        <select class="form-control" id="pilihKegiatan" required>
            <option disabled selected>-- Pilih Kegiatan --</option>
            @foreach($kegiatanList as $item)
                <option value="{{ $item->id }}">{{ $item->nama_kegiatan }} - {{ $item->tanggal }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Tampilkan</button>
</form>


@if(isset($kegiatan))
<!-- Keterangan Kegiatan -->
<div class="card mb-3" id="keteranganKegiatan">
    <div class="card-body">
        <h5 class="card-title">Nama Kegiatan: {{ $kegiatan->nama_kegiatan }}</h5>
        <p class="card-text"><strong>Tanggal:</strong> {{ $kegiatan->tanggal }}</p>
        <p class="card-text"><strong>Deskripsi:</strong> {{ $kegiatan->deskripsi }}</p>
    </div>
</div>

<!-- Tombol Tambah Absensi -->
<div class="card-body">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Absensi</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $a)
            <tr>
                <td>{{ $a->nama }}</td>
                <td>{{ $a->alamat }}</td>
                <td>{{ $a->nomor_hp }}</td>
                <td>{{ $a->status_kehadiran }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Absensi -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('kegiatan.absensi.simpan', $kegiatan->id) }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="nomor_hp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Kehadiran</label>
                    <select name="status_kehadiran" class="form-control" required>
                        <option value="Hadir">Hadir</option>
                        <option value="Tidak Hadir">Tidak Hadir</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endif



<script>
    document.getElementById('pilihKegiatan').addEventListener('change', function () {
        let kegiatan = this.value;
        let keterangan = document.getElementById('keteranganKegiatan');
        let dataAbsensi = document.getElementById('dataAbsensi');
        
        if (kegiatan === 'kerja-bakti') {
            keterangan.innerHTML = `
                <div class="card-body">
                    <h5 class="card-title">Nama Kegiatan: Kerja Bakti Lingkungan</h5>
                    <p class="card-text"><strong>Tanggal:</strong> 2024-03-17</p>
                    <p class="card-text"><strong>Deskripsi:</strong> Kegiatan membersihkan lingkungan sekitar RT 05 untuk menciptakan lingkungan yang bersih dan sehat.</p>
                </div>`;
            dataAbsensi.innerHTML = `<tr>
                <td>Budi Santoso</td>
                <td>Jl. Merdeka No. 10</td>
                <td>08123456789</td>
                <td>Hadir</td>
                <td><button class="btn btn-sm btn-danger">Hapus</button></td>
            </tr>`;
        } else if (kegiatan === 'senam-pagi') {
            keterangan.innerHTML = `
                <div class="card-body">
                    <h5 class="card-title">Nama Kegiatan: Senam Pagi</h5>
                    <p class="card-text"><strong>Tanggal:</strong> 2024-03-10</p>
                    <p class="card-text"><strong>Deskripsi:</strong> Senam pagi bersama di lapangan untuk meningkatkan kesehatan warga.</p>
                </div>`;
            dataAbsensi.innerHTML = `<tr>
                <td>Siti Aisyah</td>
                <td>Jl. Sehat No. 15</td>
                <td>08129876543</td>
                <td>Hadir</td>
                <td><button class="btn btn-sm btn-danger">Hapus</button></td>
            </tr>`;
        }
    });
</script>
@endsection