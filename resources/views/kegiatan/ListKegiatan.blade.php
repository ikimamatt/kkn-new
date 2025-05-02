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
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Dokumentasi</th>
            @if(auth()->user()->role !== 'warga')
                <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($kegiatan as $item)
        <tr>
            <td>{{ $item->nama_kegiatan }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->deskripsi }}</td>
            <td>
                <div class="d-flex overflow-auto" style="max-width: 300px;">
                    @foreach (json_decode($item->dokumentasi ?? '[]', true) as $img)
                        <img src="{{ asset('storage/' . $img) }}" class="img-thumbnail me-2" style="width: 100px; height: 100px;">
                    @endforeach
                </div>
            </td>
            @if(auth()->user()->role !== 'warga')
            <td>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $item->id }}">Upload Foto</button>
            </td>
            @endif
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
                        <input class="form-control" type="file" name="foto" required onchange="previewImage(event, {{ $item->id }})">
                    </div>
                    <div class="mb-3">
                        <img id="imagePreview{{ $item->id }}" src="#" alt="Preview Foto" style="display: none; max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;" />
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
function previewImage(event, id) {
    const reader = new FileReader();
    reader.onload = function() {
        const img = document.getElementById('imagePreview' + id);
        img.src = reader.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}

</script>
@endsection