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

<!-- Tambah Kegiatan -->
<div class="mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addKegiatanModal">Tambah Kegiatan</button>
</div>

<!-- Pilih Kegiatan -->
<div class="mb-3">
    <label for="pilihKegiatan" class="form-label">Pilih Kegiatan</label>
    <select class="form-control" id="pilihKegiatan">
        <option value="kerja-bakti">Kerja Bakti Lingkungan - 2024-03-17</option>
        <option value="senam-pagi">Senam Pagi - 2024-03-10</option>
    </select>
</div>

<!-- Keterangan Kegiatan -->
<div class="card mb-3" id="keteranganKegiatan">
    <div class="card-body">
        <h5 class="card-title">Nama Kegiatan: Kerja Bakti Lingkungan</h5>
        <p class="card-text"><strong>Tanggal:</strong> 2024-03-17</p>
        <p class="card-text"><strong>Deskripsi:</strong> Kegiatan membersihkan lingkungan sekitar RT 05 untuk menciptakan lingkungan yang bersih dan sehat.</p>
    </div>
</div>

<div class="card-body">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Absensi</button>
    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomor HP</th>
                <th>Status Kehadiran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="dataAbsensi">
            <tr>
                <td>Budi Santoso</td>
                <td>Jl. Merdeka No. 10</td>
                <td>08123456789</td>
                <td>Hadir</td>
                <td><button class="btn btn-sm btn-danger">Hapus</button></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal untuk Tambah Kegiatan -->
<div class="modal fade" id="addKegiatanModal" tabindex="-1" aria-labelledby="addKegiatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKegiatanModalLabel">Tambah Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addKegiatanForm">
                    <div class="mb-3">
                        <label for="namaKegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="namaKegiatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalKegiatan" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggalKegiatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsiKegiatan" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsiKegiatan" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

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