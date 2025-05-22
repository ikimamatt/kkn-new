@extends('layouts.vertical', ['title' => 'Data Rumah'])

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
        <h4 class="fs-18 fw-semibold m-0">Data Rumah di Blok {{ $block->name }}</h4>
    </div>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
            <li class="breadcrumb-item active">Data Rumah</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Data Rumah</h5>
            </div>

            <div class="p-1">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createHouseModal">Tambah Rumah</button>
                </div>
            </div>

            <!-- Modal Create -->
            <div class="modal fade" id="createHouseModal" tabindex="-1" aria-labelledby="createHouseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createHouseModalLabel">Tambah Rumah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('house.store', $block->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="house_number" class="form-label">Nomor Rumah</label>
                                    <input type="text" class="form-control" id="house_number" name="house_number" value="{{ $block->name }}-" required>
                                    <small>Contoh: {{ $block->name }}-1</small>
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
                            <th>Nomor Rumah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($houses as $house)
                            <tr>
                                <td>{{ $house->house_number }}</td>
                                <td>
                                    <a href="{{ route('familyCard.index', $house->id) }}" class="btn btn-primary btn-sm">Lihat Kartu Keluarga</a>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateHouseModal{{ $house->id }}">Edit</button>
                                    <form action="{{ route('house.destroy', $house->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $house->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $house->id }})">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="updateHouseModal{{ $house->id }}" tabindex="-1" aria-labelledby="updateHouseModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateHouseModalLabel">Edit Rumah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('house.update', $house->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="house_number" class="form-label">Nomor Rumah</label>
                                                    <input type="text" class="form-control" value="{{ $house->house_number }}" id="house_number" name="house_number" required>
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
