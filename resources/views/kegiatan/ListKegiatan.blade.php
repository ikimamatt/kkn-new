@extends('layouts.vertical', ['title' => 'General Elements'])

@section('content')

<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Kegiatan</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Kegiatan</a></li>
            <li class="breadcrumb-item active">List Kegiatan</li>
        </ol>
    </div>
</div>

@if(auth()->user()->role !== 'warga')
<div class="text-start">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addActivityModal">Tambah Kegiatan</button>
    </div>
@endif

<div class="card-body mt-3 table-responsive">
<table class="table table-bordered table-striped">
    <tbody>
    @foreach ($kegiatan as $item)
    <tr>
    <!-- Baris 1: Nama, Tanggal, Deskripsi -->
    <td colspan="5">
        <strong>{{ $item->nama_kegiatan }}</strong><br>
        <small>{{ $item->tanggal }}</small><br>
        <p>{{ $item->deskripsi }}</p>
    </td>
    @if(auth()->user()->role !== 'warga')
    <td rowspan="3" class="align-middle text-center" style="vertical-align: middle;">
    <div class="d-grid gap-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $item->id }}">
            <i class="fas fa-upload"></i> Upload Dokumentasi
        </button>
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#uploadAbsensiModal{{ $item->id }}">
            Upload Absensi
        </button>
    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editKegiatanModal{{ $item->id }}">
        Edit
    </button>

    <form action="{{ route('kegiatan.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>
    </div>
</td>

    @endif
</tr>

<!-- Baris 2: Dokumentasi -->
<tr>
    <td colspan="5">
        <div class="overflow-auto" style="white-space: nowrap;">
            @foreach (json_decode($item->dokumentasi ?? '[]', true) as $index => $img)
                <div class="d-inline-block me-2">
                    <img src="{{ asset('storage/' . $img) }}"
                        onerror="this.src='/default.png';"
                         class="img-fluid rounded"
                         style="max-height: 100px; cursor: pointer;"
                         alt="Dokumentasi"
                         data-bs-toggle="modal"
                         data-bs-target="#modalDokumentasi{{ $item->id }}_{{ $index }}">
                </div>

                <!-- Modal Dokumentasi -->
                <div class="modal fade" id="modalDokumentasi{{ $item->id }}_{{ $index }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-body text-center p-0">
                                <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded" alt="Dokumentasi">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </td>
</tr>

<!-- Baris 3: Absensi -->
<tr>
    <td colspan="5">
        <div class="overflow-auto" style="white-space: nowrap;">
            @foreach (json_decode($item->absensi ?? '[]', true) as $index => $img)
                <div class="d-inline-block me-2">
                    <img src="{{ asset('storage/' . $img) }}"
                         class="img-fluid rounded"
                         style="max-height: 100px; cursor: pointer;"
                         alt="Absensi"
                         data-bs-toggle="modal"
                         data-bs-target="#modalAbsensi{{ $item->id }}_{{ $index }}">
                </div>

                <!-- Modal Absensi -->
                <div class="modal fade" id="modalAbsensi{{ $item->id }}_{{ $index }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-body text-center p-0">
                                <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded" alt="Absensi">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </td>
</tr>

<tr>
    <td colspan="6" style="height: 15px; background-color: #f1f4fb; border:none;"></td>
</tr>


<!-- Modal Upload Foto Per Kegiatan -->
<div class="modal fade" id="uploadModal{{ $item->id }}" tabindex="-1" aria-labelledby="uploadModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Foto Dokumentasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('kegiatan.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih Foto</label>
                        <input class="form-control" type="file"  name="foto[]" multiple required onchange="previewImage(event, {{ $item->id }}, 'Doc')">
                    </div>
                    <div class="mb-3">
                        <div id="imagePreviewDoc{{ $item->id }}" src="#" alt="Preview Foto" style="display: none; max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;"></div>

                    </div>
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Kegiatan -->
<div class="modal fade" id="editKegiatanModal{{ $item->id }}" tabindex="-1" aria-labelledby="editKegiatanModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('kegiatan.update', $item->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="nama_kegiatan" value="{{ $item->nama_kegiatan }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ $item->tanggal }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" required>{{ $item->deskripsi }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Modal Upload Foto Absensi -->
    <div class="modal fade" id="uploadAbsensiModal{{ $item->id }}" tabindex="-1" aria-labelledby="uploadAbsensiModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Foto Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kegiatan.uploadAbsensi', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih Foto Absensi</label>
                            <input class="form-control" type="file" name="foto_absensi" required onchange="previewImage(event, {{ $item->id }}, 'Abs')">
                        </div>
                        <div class="mb-3">
                            <div id="imagePreviewAbs{{ $item->id }}" src="#" alt="Preview Foto" style="display: none; max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Unggah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endforeach
    </tbody>
</table>
<!-- Modal untuk Tambah Kegiatan -->
<div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addActivityModalLabel">Tambah Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <form method="POST" action="{{ route('kegiatan.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="activityName" class="form-label">Nama Kegiatan</label>
        <input type="text" class="form-control" id="activityName" name="nama_kegiatan" required>
    </div>
    <div class="mb-3">
        <label for="activityDate" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="activityDate" name="tanggal" required>
    </div>
    <div class="mb-3">
        <label for="activityDesc" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="activityDesc" name="deskripsi" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Tambah</button>
</form>


            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>

function previewImage(event, id, type) {
    const files = event.target.files;
    const previewContainerId = 'imagePreview' + type + id;
    const previewContainer = document.getElementById(previewContainerId);
    
    previewContainer.innerHTML = '';
    previewContainer.style.display = 'block';

    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = function () {
            const img = document.createElement('img');
            img.src = reader.result;
            img.className = 'img-fluid rounded me-2 mb-2';
            img.style.maxHeight = '100px';
            img.style.border = '1px solid #ddd';
            img.style.padding = '5px';
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(files[i]);
    }
}
</script>
@endsection
