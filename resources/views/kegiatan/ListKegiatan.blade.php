@extends('layouts.vertical', ['title' => 'Kegiatan Warga'])

@section('content')

<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Kegiatan Warga</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Kegiatan</a></li>
            <li class="breadcrumb-item active">List Kegiatan</li>
        </ol>
    </div>
</div>

@if(auth()->user()->role !== 'warga')
<div class="text-start mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addActivityModal">Tambah Kegiatan</button>
</div>
@endif

<div class="card-body table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
                <th>Tanggal</th>
                <th class="d-none d-md-table-cell">Deskripsi</th>
                <th>Dokumentasi</th>
                <th>Absensi</th>
                @if(auth()->user()->role !== 'warga')
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($kegiatan as $item)
<tr>
    <td><strong>{{ $item->nama_kegiatan }}</strong></td>
    <td><small>{{ $item->tanggal }}</small></td>
    <td class="d-none d-md-table-cell"><p>{{ $item->deskripsi }}</p></td>

    {{-- Kolom Dokumentasi --}}
    <td style="height: 100px;" class="align-middle text-center">
        @if (!empty(json_decode($item->dokumentasi ?? '[]')))
            <button class="btn btn-info btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#galleryModal"
                    data-images="{{ $item->dokumentasi }}"
                    data-title="Dokumentasi: {{ $item->nama_kegiatan }}">
                Lihat Dokumentasi ({{ count(json_decode($item->dokumentasi)) }})
            </button>
        @else
            Tidak Ada
        @endif
    </td>

    {{-- Kolom Absensi --}}
    <td style="height: 100px;" class="align-middle text-center">
        @if (!empty(json_decode($item->absensi ?? '[]')))
            <button class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#galleryModal"
                    data-images="{{ $item->absensi }}"
                    data-title="Absensi: {{ $item->nama_kegiatan }}">
                Lihat Absensi ({{ count(json_decode($item->absensi)) }})
            </button>
        @else
            Tidak Ada
        @endif
    </td>

    @if(auth()->user()->role !== 'warga')
    <td>
        <div class="d-grid gap-2">
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKegiatanModal{{ $item->id }}">
                Edit
            </button>
            <form action="{{ route('kegiatan.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm w-100">Hapus</button>
            </form>
        </div>
    </td>
    @endif
</tr>
@endforeach

        </tbody>
    </table>
</div>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel">Pratinjau Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="imageGalleryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="galleryModalCarouselInner">
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#imageGalleryCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon carousel-dark-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#imageGalleryCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon carousel-dark-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
</button>

                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($kegiatan as $item)
<div class="modal fade" id="editKegiatanModal{{ $item->id }}" tabindex="-1" aria-labelledby="editKegiatanModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('kegiatan.update', $item->id) }}" enctype="multipart/form-data">
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

                    <div class="mb-3">
                        <label class="form-label">Foto Dokumentasi (Tambahkan/Perbarui)</label>
                        <input class="form-control" type="file" name="dokumentasi_baru[]" multiple onchange="previewImage(event, 'editDoc{{ $item->id }}', 'Doc')">
                        <small class="text-muted">Upload foto baru untuk ditambahkan ke dokumentasi yang sudah ada.</small>
                    </div>
                    <div class="mb-3" id="imagePreviewDoceditDoc{{ $item->id }}" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>

                    {{-- Bagian Dokumentasi Saat Ini dengan Tombol Hapus --}}
                    @if (!empty(json_decode($item->dokumentasi ?? '[]')))
                        <div class="mb-3">
                            <label class="form-label">Dokumentasi Saat Ini:</label>
                            <div id="currentDokumentasiContainer{{ $item->id }}" style="display: flex; flex-wrap: wrap; gap: 5px;">
                                @foreach (json_decode($item->dokumentasi, true) as $index => $img)
                                    <div class="position-relative d-inline-block p-1 border" id="dokumentasi-{{ $item->id }}-{{ $index }}">
                                        <img src="{{ asset('storage/' . $img) }}"
                                             onerror="this.src='/default.png';"
                                             class="img-thumbnail"
                                             style="width: 70px; height: 70px; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle p-0"
                                                style="width: 20px; height: 20px; font-size: 0.7rem; line-height: 1; display: flex; align-items: center; justify-content: center;"
                                                onclick="removeImage('dokumentasi-{{ $item->id }}-{{ $index }}', '{{ $img }}', 'removed_dokumentasi_paths{{ $item->id }}')">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Input tersembunyi untuk melacak gambar yang dihapus --}}
                            <input type="hidden" name="removed_dokumentasi_paths" id="removed_dokumentasi_paths{{ $item->id }}" value="">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Foto Absensi (Tambahkan/Perbarui)</label>
                        <input class="form-control" type="file" name="absensi_baru" onchange="previewImage(event, 'editAbs{{ $item->id }}', 'Abs')">
                        <small class="text-muted">Upload foto baru untuk mengganti atau menambahkan absensi.</small>
                    </div>
                    <div class="mb-3" id="imagePreviewAbseditAbs{{ $item->id }}" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>

                    {{-- Bagian Absensi Saat Ini dengan Tombol Hapus --}}
                    @if (!empty(json_decode($item->absensi ?? '[]')))
                        <div class="mb-3">
                            <label class="form-label">Absensi Saat Ini:</label>
                            <div id="currentAbsensiContainer{{ $item->id }}" style="display: flex; flex-wrap: wrap; gap: 5px;">
                                @foreach (json_decode($item->absensi, true) as $index => $img)
                                    <div class="position-relative d-inline-block p-1 border" id="absensi-{{ $item->id }}-{{ $index }}">
                                        <img src="{{ asset('storage/' . $img) }}"
                                             class="img-thumbnail"
                                             style="width: 70px; height: 70px; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle p-0"
                                                style="width: 20px; height: 20px; font-size: 0.7rem; line-height: 1; display: flex; align-items: center; justify-content: center;"
                                                onclick="removeImage('absensi-{{ $item->id }}-{{ $index }}', '{{ $img }}', 'removed_absensi_paths{{ $item->id }}')">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Input tersembunyi untuk melacak gambar yang dihapus --}}
                            <input type="hidden" name="removed_absensi_paths" id="removed_absensi_paths{{ $item->id }}" value="">
                        </div>
                    @endif

                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addActivityModalLabel">Tambah Kegiatan Baru</h5>
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
                    <div class="mb-3">
                        <label for="activityPhotos" class="form-label">Foto Dokumentasi (Opsional)</label>
                        <input class="form-control" type="file" id="activityPhotos" name="dokumentasi[]" multiple onchange="previewImage(event, 'newActivityDoc', 'Doc')">
                        <small class="text-muted">Anda bisa mengunggah lebih dari satu foto.</small>
                    </div>
                    <div class="mb-3" id="imagePreviewDocnewActivityDoc" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>

                    <div class="mb-3">
                        <label for="activityAbsensi" class="form-label">Foto Absensi (Opsional)</label>
                        <input class="form-control" type="file" id="activityAbsensi" name="absensi" onchange="previewImage(event, 'newActivityAbs', 'Abs')">
                        <small class="text-muted">Unggah satu foto untuk absensi.</small>
                    </div>
                    <div class="mb-3" id="imagePreviewAbsnewActivityAbs" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>

                    <button type="submit" class="btn btn-success">Tambah Kegiatan</button>
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

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;

            img.style.width = '80px';
            img.style.height = '80px';
            img.style.objectFit = 'cover';
            img.classList.add('img-thumbnail');

            previewContainer.appendChild(img);
        };

        reader.readAsDataURL(file);
    }
}

function removeImage(elementId, imagePath, hiddenInputId) {
    const elementToRemove = document.getElementById(elementId);
    if (elementToRemove) {
        elementToRemove.remove(); 

        const hiddenInput = document.getElementById(hiddenInputId);
        let removedPaths = hiddenInput.value ? JSON.parse(hiddenInput.value) : [];
        removedPaths.push(imagePath);
        hiddenInput.value = JSON.stringify(removedPaths);
    }
}


const galleryModal = document.getElementById('galleryModal');
galleryModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const images = JSON.parse(button.getAttribute('data-images') || '[]');
    const title = button.getAttribute('data-title') || 'Galeri';

    document.getElementById('galleryModalLabel').textContent = title;

    const carouselInner = document.getElementById('galleryModalCarouselInner');
    carouselInner.innerHTML = '';

    if (images.length === 0) {
        carouselInner.innerHTML = '<div class="text-center text-muted">Tidak ada gambar.</div>';
        return;
    }

    images.forEach((img, index) => {
        const item = document.createElement('div');
        item.className = 'carousel-item' + (index === 0 ? ' active' : '');

        const image = document.createElement('img');
        image.src = `/storage/${img}`;
        image.className = 'd-block w-100';
        image.style.maxHeight = '500px';
        image.style.objectFit = 'contain';

        item.appendChild(image);
        carouselInner.appendChild(item);
    });
});
</script>

@section('style')
<style>
    .carousel-dark-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23000' viewBox='0 0 8 8'%3E%3Cpath d='M4.146 0.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L5 1.707V7.5a.5.5 0 0 1-1 0V1.707L1.854 3.854a.5.5 0 0 1-.708-.708l3-3z'/%3E%3C/svg%3E");
        background-size: 100% 100%;
    }
</style>
@endsection

@endsection