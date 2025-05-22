@extends('layouts.vertical', ['title' => 'Data Kartu Keluarga'])

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
        <h4 class="fs-18 fw-semibold m-0">Data Kartu Keluarga di Rumah {{ $house->house_number }}</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
            <li class="breadcrumb-item active">Data Kartu Keluarga</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Data Kartu Keluarga</h5>
            </div>

            <div class="p-1">
                <div class="d-flex flex-wrap gap-2">
                    <!-- Tombol untuk membuka modal Create -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFamilyCardModal">Tambah Kartu Keluarga</button>
                </div>
            </div>

            <div class="card-body">
                <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Nomor Kartu Keluarga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($familyCards as $familyCard)
                            <tr>
                                <td>
                                    <a href="{{ route('user.index', $familyCard->id) }}" class="tp-link">{{ $familyCard->kk_number }}</a>
                                </td>

                                <td>
                                    <!-- Tombol Edit dan Hapus -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editFamilyCardModal{{ $familyCard->id }}">Edit</button>
                                    <form action="{{ route('familyCard.destroy', $familyCard->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $familyCard->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $familyCard->id }})">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit untuk Kartu Keluarga -->
                            <div class="modal fade" id="editFamilyCardModal{{ $familyCard->id }}" tabindex="-1" aria-labelledby="editFamilyCardModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editFamilyCardModalLabel">Edit Kartu Keluarga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('familyCard.update', $familyCard->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="kk_number" class="form-label">Nomor Kartu Keluarga</label>
                                                    <input type="text" class="form-control" value="{{ $familyCard->kk_number }}" id="kk_number" name="kk_number" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kk_photo" class="form-label">Foto Kartu Keluarga</label>
                                                    <input type="file" class="form-control" id="kk_photo" name="kk_photo" accept="image/*">

                                                        <img src="{{ asset('storage/' . $familyCard->kk_photo) }}" alt="Foto Kartu Keluarga" class="img-thumbnail mt-2" width="150">

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

<!-- Modal Create untuk Kartu Keluarga -->
<div class="modal fade" id="createFamilyCardModal" tabindex="-1" aria-labelledby="createFamilyCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFamilyCardModalLabel">Tambah Kartu Keluarga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <div class="modal-body">
    <form method="POST" action="{{ route('familyCard.store', $house->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="kk_number" class="form-label">Nomor Kartu Keluarga</label>
            <input type="text" class="form-control" id="kk_number" pattern="^\d{16}$" maxlength="16" name="kk_number" required>
            <div class="invalid-feedback">
                Nomor Kartu Keluarga harus terdiri dari 16 digit angka.
            </div>
              <div class="mb-3">
                    <label for="kk_photo" class="form-label">Foto Kartu Keluarga</label>
                    <input type="file" class="form-control" id="kk_photo" name="kk_photo" accept="image/*">
                </div>
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
