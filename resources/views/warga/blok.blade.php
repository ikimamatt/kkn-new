@extends('layouts.vertical', ['title' => 'Data Blok'])

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
        <h4 class="fs-18 fw-semibold m-0">Data Blok</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
            <li class="breadcrumb-item active">Data Blok</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Data Blok</h5>
            </div>

            <div class="p-3 ml-4">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBlockModal">Tambah Blok</button>
                </div>
            </div>

            <!-- Modal Create -->
            <div class="modal fade" id="createBlockModal" tabindex="-1" aria-labelledby="createBlockModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createBlockModalLabel">Tambah Blok</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('block.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="block_name" class="form-label">Nama Blok</label>
                                    <input type="text" class="form-control" id="block_name" name="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap table-striped w-100">
                    <thead>
                        <tr>
                            <th>Nama Blok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blocks as $block)
                            <tr>
                                <td>
                                    <a href="{{ route('house.index', $block->id) }}" class="tp-link">{{ $block->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('house.index', $block->id) }}" class="tp-link">
                                        <button class="btn btn-primary btn-sm">Lihat Daftar Rumah</button>
                                    </a>

                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateBlockModal{{ $block->name }}" onclick="editBlock({{ $block->id }})">Edit</button>
                                    <form action="{{ route('block.destroy', $block->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $block->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $block->id }})">Hapus</button>
                                    </form>

                                </td>
                            </tr>
                            <div class="modal fade" id="updateBlockModal{{ $block->name }}" tabindex="-1" aria-labelledby="updateBlockModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateBlockModalLabel">Update Blok</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('block.update', $block->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="update_block_id" name="id">
                                                <div class="mb-3">
                                                    <label for="update_block_name" class="form-label">Nama Blok</label>
                                                    <input type="text" class="form-control" value="{{ $block->name }}" id="update_block_name" name="name" required>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('script')
    @vite([ 'resources/js/pages/datatable.init.js'])

    <script>
        function editBlock(id) {
            fetch(`/superadmin/dashboard/block/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('update_block_id').value = data.id;
                    document.getElementById('update_block_name').value = data.name;
                    document.querySelector('form').action = `/superadmin/dashboard/block/${data.id}`;
                });
        }
    </script>
<script>
    function confirmDelete(blockId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan bisa membatalkan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, kirimkan form
                document.getElementById('delete-form-' + blockId).submit();
            }
        });
    }
</script>


@endsection
