@extends('layouts.vertical', ['title' => 'Nomor Darurat'])

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
        <h4 class="fs-18 fw-semibold m-0">Nomor Darurat</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Nomor Darurat</a></li>
            <li class="breadcrumb-item active">{{ $unit->unit_name }}</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Nomor Darurat di {{ $unit->unit_name }}</h5>
            </div>
            @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'administrator')

            <div class="p-1">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNumberModal">Tambah Nomor Darurat</button>
                </div>
            </div>

            <!-- Modal Create Number -->
            <div class="modal fade" id="createNumberModal" tabindex="-1" aria-labelledby="createNumberModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createNumberModalLabel">Tambah Nomor Darurat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('emergency_numbers.store', $unit->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="location" class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" id="location" name="location" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="card-body">
                <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap table-striped w-100">
                    <thead>
                        <tr>
                            <th>Lokasi</th>
                            <th>Nomor Telepon</th>
                            @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'administrator')

                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($numbers as $number)
                            <tr>
                                <td>{{ $number->location }}</td>
                                <td>{{ $number->phone_number }}</td>
                                 @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'administrator')

                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editNumberModal{{ $number->id }}">Edit</button>
                                    <form action="{{ route('emergency_numbers.destroy', $number->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $number->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $number->id }})">Delete</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            <!-- Modal Edit Number -->
<div class="modal fade" id="editNumberModal{{ $number->id }}" tabindex="-1" aria-labelledby="editNumberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNumberModalLabel">Edit Nomor Darurat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk edit nomor darurat -->
                <form method="POST" action="{{ route('emergency_numbers.update', $number->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Hidden input untuk ID nomor darurat -->
                    <input type="hidden" name="number_id" id="number_id" value="{{ $number->id }}">

                    <div class="mb-3">
                        <label for="edit_location" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="edit_location" name="location" value="{{ $number->location }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_phone_number" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="edit_phone_number" name="phone_number" value="{{ $number->phone_number }}" required>
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

@endsection

@section('script')
    @vite([ 'resources/js/pages/datatable.init.js'])
@endsection
