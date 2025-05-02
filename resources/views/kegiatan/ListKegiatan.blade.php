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

<div class="text-start">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addActivityModal">Tambah Kegiatan</button>
    </div>

<div class="card-body mt-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Dokumentasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Senam Pagi</td>
                <td>2025-10-10</td>
                <td>Kegiatan senam pagi bersama warga</td>
                <td>
                    <div class="d-flex overflow-auto" style="max-width: 300px;">
                        <img src="path/to/image1.jpg" class="img-thumbnail me-2" style="width: 100px; height: 100px;">
                        <img src="path/to/image2.jpg" class="img-thumbnail me-2" style="width: 100px; height: 100px;">
                    </div>
                </td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Foto</button>
                    <button class="btn btn-primary btn-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>Pelatihan Web</td>
                <td>2025-10-10</td>
                <td>Kegiatan pelatihan web kepada warga dan pengurus rt</td>
                <td>
                    <div class="d-flex overflow-auto" style="max-width: 300px;">
                        <img src="path/to/image1.jpg" class="img-thumbnail me-2" style="width: 100px; height: 100px;">
                        <img src="path/to/image2.jpg" class="img-thumbnail me-2" style="width: 100px; height: 100px;">
                    </div>
                </td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Foto</button>
                    <button class="btn btn-primary btn-danger">Hapus</button>
                </td>
            </tr>
            
        </tbody>
    </table>
</div>

<!-- Modal untuk Upload Foto -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Foto Dokumentasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Pilih Foto</label>
                        <input class="form-control" type="file" id="formFile" onchange="previewImage(event)">
                    </div>
                    <div class="mb-3">
                        <img id="imagePreview" src="#" alt="Preview Foto" style="display: none; max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;" />
                    </div>
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Kegiatan -->
<div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addActivityModalLabel">Tambah Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="activityName" class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="activityName" required>
                    </div>
                    <div class="mb-3">
                        <label for="activityDate" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="activityDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="activityDate" class="form-label">Deskripsi</label>
                        <input type="date" class="form-control" id="activityDesc" required>
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
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var img = document.getElementById('imagePreview');
            img.src = reader.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection
