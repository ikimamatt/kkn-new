@extends('layouts.vertical', ['title' => 'Unit Darurat'])

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
        <h4 class="fs-18 fw-semibold m-0">Unit Darurat</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Unit Darurat</a></li>
            <li class="breadcrumb-item active">Daftar Unit</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Unit Darurat</h5>
            </div>

            <div class="p-1">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUnitModal">Tambah Unit</button>
                </div>
            </div>

            <!-- Modal Create Unit -->
            <div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUnitModalLabel">Tambah Unit Darurat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('emergency_units.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="unit_name" class="form-label">Nama Unit</label>
                                    <input type="text" class="form-control" id="unit_name" name="unit_name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap table-striped w-100">
                    <thead>
                        <tr>
                            <th>Nama Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $unit)
                            <tr>
                                <td>
                                    <a href="{{ route('emergency_units.show', $unit->id) }}" class="tp-link">{{ $unit->unit_name }}</a>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUnitModal{{ $unit->id }}">Edit</button>
                                    <form action="{{ route('emergency_units.destroy', $unit->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Modal Edit Unit -->
<div class="modal fade" id="editUnitModal{{ $unit->id }}" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUnitModalLabel">Edit Unit Darurat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk edit unit darurat -->
                <form method="POST" action="{{ route('emergency_units.update', $unit->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Hidden input untuk ID unit darurat -->
                    <input type="hidden" name="unit_id" id="unit_id" value="{{ $unit->id }}">

                    <div class="mb-3">
                        <label for="edit_unit_name" class="form-label">Nama Unit</label>
                        <input type="text" class="form-control" id="edit_unit_name" name="unit_name" value="{{ $unit->unit_name }}" required>
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
