@extends('layouts.vertical', ['title' => 'Data User'])

@section('css')
    @vite([
        'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
        'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
        'node_modules/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css',
        'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
        'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'
    ])
@endsection

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Anggota Keluarga di Kartu Keluarga {{ $familyCard->kk_number }}</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
            <li class="breadcrumb-item active">Anggota Keluarga</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Anggota Keluarga</h5>
            </div>

            <div class="p-1">
                <div class="d-flex flex-wrap gap-2">
                    <!-- Tombol untuk membuka modal Create -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Tambah Anggota Keluarga</button>
                </div>
            </div>

            <div class="card-body">
                <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIK</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->nik }}</td>
                                <td>
                                    <!-- Tombol Edit dan Hapus -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit untuk Anggota Keluarga -->
                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel">Edit Anggota Keluarga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('user.update', $user->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" value="{{ $user->name }}" id="name" name="name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="{{ $user->email }}" id="email" name="email" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                                    <input type="text" class="form-control" value="{{ $user->nik }}" id="nik" name="nik" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" value="{{ $user->tanggal_lahir }}" id="tanggal_lahir" name="tanggal_lahir" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                        <option value="L" {{ $user->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="P" {{ $user->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                    <input type="text" class="form-control" value="{{ $user->tempat_lahir }}" id="tempat_lahir" name="tempat_lahir" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                                                    <input type="text" class="form-control" value="{{ $user->jenis_pekerjaan }}" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                                    <input type="text" class="form-control" value="{{ $user->golongan_darah }}" id="golongan_darah" name="golongan_darah">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                                    <select class="form-select" id="status_perkawinan" name="status_perkawinan" required>
                                                        <option value="belum_kawin" {{ $user->status_perkawinan == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                                        <option value="kawin" {{ $user->status_perkawinan == 'kawin' ? 'selected' : '' }}>Kawin</option>
                                                        <option value="cerai" {{ $user->status_perkawinan == 'cerai' ? 'selected' : '' }}>Cerai</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal_perkawinan_atau_perceraian" class="form-label">Tanggal Perkawinan atau Perceraian</label>
                                                    <input type="date" class="form-control" value="{{ $user->tanggal_perkawinan_atau_perceraian }}" id="tanggal_perkawinan_atau_perceraian" name="tanggal_perkawinan_atau_perceraian">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status_hubungan_keluarga" class="form-label">Status Hubungan Keluarga</label>
                                                    <select class="form-select" id="status_hubungan_keluarga" name="status_hubungan_keluarga" required>
                                                        <option value="kepala_keluarga" {{ $user->status_hubungan_keluarga == 'kepala_keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                                        <option value="istri" {{ $user->status_hubungan_keluarga == 'istri' ? 'selected' : '' }}>Istri</option>
                                                        <option value="anak" {{ $user->status_hubungan_keluarga == 'anak' ? 'selected' : '' }}>Anak</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create untuk Anggota Keluarga -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Tambah Anggota Keluarga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.store', $familyCard->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" class="form-control" id="nik" name="nik" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                        <input type="text" class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
                    </div>
                    <div class="mb-3">
                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                        <input type="text" class="form-control" id="golongan_darah" name="golongan_darah">
                    </div>
                    <div class="mb-3">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                        <select class="form-select" id="status_perkawinan" name="status_perkawinan" required>
                            <option value="belum_kawin">Belum Kawin</option>
                            <option value="kawin">Kawin</option>
                            <option value="cerai">Cerai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_perkawinan_atau_perceraian" class="form-label">Tanggal Perkawinan atau Perceraian</label>
                        <input type="date" class="form-control" id="tanggal_perkawinan_atau_perceraian" name="tanggal_perkawinan_atau_perceraian">
                    </div>
                    <div class="mb-3">
                        <label for="status_hubungan_keluarga" class="form-label">Status Hubungan Keluarga</label>
                        <select class="form-select" id="status_hubungan_keluarga" name="status_hubungan_keluarga" required>
                            <option value="kepala_keluarga">Kepala Keluarga</option>
                            <option value="istri">Istri</option>
                            <option value="anak">Anak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    @vite([ 'resources/js/pages/datatable.init.js'])
@endsection
