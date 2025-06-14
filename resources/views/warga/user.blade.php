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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Tambah Anggota Keluarga</button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->nik }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit untuk Anggota Keluarga -->
                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit Anggota Keluarga</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <form method="POST" action="{{ route('user.update', $user->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name{{ $user->id }}" class="form-label">Nama</label>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name{{ $user->id }}" name="name" value="{{ old('name', $user->name) }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nik{{ $user->id }}" class="form-label">NIK</label>
                                                        <input type="text" pattern="^\d{16}$" maxlength="16" class="form-control @error('nik') is-invalid @enderror" id="nik{{ $user->id }}" name="nik" value="{{ old('nik', $user->nik) }}" required>
                                                        <small>NIK harus terdiri dari 16 angka</small>
                                                        @error('nik')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal_lahir{{ $user->id }}" class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir{{ $user->id }}" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
                                                        @error('tanggal_lahir')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jenis_kelamin{{ $user->id }}" class="form-label">Jenis Kelamin</label>
                                                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin{{ $user->id }}" name="jenis_kelamin" required>
                                                            <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                            <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                        @error('jenis_kelamin')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tempat_lahir{{ $user->id }}" class="form-label">Tempat Lahir</label>
                                                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir{{ $user->id }}" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
                                                        @error('tempat_lahir')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jenis_pekerjaan{{ $user->id }}" class="form-label">Jenis Pekerjaan</label>
                                                        <input type="text" class="form-control @error('jenis_pekerjaan') is-invalid @enderror" id="jenis_pekerjaan{{ $user->id }}" name="jenis_pekerjaan" value="{{ old('jenis_pekerjaan', $user->jenis_pekerjaan) }}" required>
                                                        @error('jenis_pekerjaan')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="golongan_darah{{ $user->id }}" class="form-label">Golongan Darah</label>
                                                        <input type="text" class="form-control @error('golongan_darah') is-invalid @enderror" id="golongan_darah{{ $user->id }}" name="golongan_darah" value="{{ old('golongan_darah', $user->golongan_darah) }}">
                                                        @error('golongan_darah')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status_perkawinan{{ $user->id }}" class="form-label">Status Perkawinan</label>
                                                        <select class="form-select @error('status_perkawinan') is-invalid @enderror" id="status_perkawinan{{ $user->id }}" name="status_perkawinan" required>
                                                            <option value="belum_kawin" {{ old('status_perkawinan', $user->status_perkawinan) == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                                            <option value="kawin" {{ old('status_perkawinan', $user->status_perkawinan) == 'kawin' ? 'selected' : '' }}>Kawin</option>
                                                            <option value="cerai_hidup" {{ old('status_perkawinan', $user->status_perkawinan) == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                                            <option value="cerai_mati" {{ old('status_perkawinan', $user->status_perkawinan) == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati</option>
                                                        </select>
                                                        @error('status_perkawinan')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal_perkawinan_atau_perceraian{{ $user->id }}" class="form-label">Tanggal Perkawinan atau Perceraian</label>
                                                        <input type="date" class="form-control @error('tanggal_perkawinan_atau_perceraian') is-invalid @enderror" id="tanggal_perkawinan_atau_perceraian{{ $user->id }}" name="tanggal_perkawinan_atau_perceraian" value="{{ old('tanggal_perkawinan_atau_perceraian', $user->tanggal_perkawinan_atau_perceraian) }}">
                                                        <small class="text-danger">Opsional</small>
                                                        @error('tanggal_perkawinan_atau_perceraian')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status_hubungan_keluarga{{ $user->id }}" class="form-label">Status Hubungan Keluarga</label>
                                                        <select class="form-select @error('status_hubungan_keluarga') is-invalid @enderror" id="status_hubungan_keluarga{{ $user->id }}" name="status_hubungan_keluarga" required>
                                                            <option value="kepala_keluarga" {{ old('status_hubungan_keluarga', $user->status_hubungan_keluarga) == 'kepala_keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                                            <option value="istri" {{ old('status_hubungan_keluarga', $user->status_hubungan_keluarga) == 'istri' ? 'selected' : '' }}>Istri</option>
                                                            <option value="anak" {{ old('status_hubungan_keluarga', $user->status_hubungan_keluarga) == 'anak' ? 'selected' : '' }}>Anak</option>
                                                        </select>
                                                        @error('status_hubungan_keluarga')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.store', $familyCard->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" pattern="^\d{16}$" maxlength="16" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" required>
                        <small class="text-danger">NIK harus terdiri dari 16 angka</small>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                        <input type="text" class="form-control @error('jenis_pekerjaan') is-invalid @enderror" id="jenis_pekerjaan" name="jenis_pekerjaan" value="{{ old('jenis_pekerjaan') }}" required>
                        @error('jenis_pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                        <input type="text" class="form-control @error('golongan_darah') is-invalid @enderror" id="golongan_darah" name="golongan_darah" value="{{ old('golongan_darah') }}">
                        @error('golongan_darah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                        <select class="form-select @error('status_perkawinan') is-invalid @enderror" id="status_perkawinan" name="status_perkawinan" required>
                            <option value="belum_kawin" {{ old('status_perkawinan') == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="kawin" {{ old('status_perkawinan') == 'kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="cerai_hidup" {{ old('status_perkawinan') == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="cerai_mati" {{ old('status_perkawinan') == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                        @error('status_perkawinan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_perkawinan_atau_perceraian" class="form-label">Tanggal Perkawinan atau Perceraian</label>
                        <input type="date" class="form-control @error('tanggal_perkawinan_atau_perceraian') is-invalid @enderror" id="tanggal_perkawinan_atau_perceraian" name="tanggal_perkawinan_atau_perceraian" value="{{ old('tanggal_perkawinan_atau_perceraian') }}">
                        <small class="text-danger">Opsional</small>
                        @error('tanggal_perkawinan_atau_perceraian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_hubungan_keluarga" class="form-label">Status Hubungan Keluarga</label>
                        <select class="form-select @error('status_hubungan_keluarga') is-invalid @enderror" id="status_hubungan_keluarga" name="status_hubungan_keluarga" required>
                            <option value="kepala_keluarga" {{ old('status_hubungan_keluarga') == 'kepala_keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="istri" {{ old('status_hubungan_keluarga') == 'istri' ? 'selected' : '' }}>Istri</option>
                            <option value="anak" {{ old('status_hubungan_keluarga') == 'anak' ? 'selected' : '' }}>Anak</option>
                        </select>
                        @error('status_hubungan_keluarga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
