@extends('layouts.vertical', ['title' => 'Keuangan RT'])

@section('content')
    @if (session('success'))
        <div id="autoDismissAlert"
            class="alert alert-success alert-dismissible fade show fixed-top mx-auto mt-4 shadow z-50 w-75 px-3"
            role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif ($errors->any())
        <div id="autoDismissAlert"
            class="alert alert-success alert-danger fade show fixed-top mx-auto mt-4 shadow z-50 w-75 px-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                <div>
                    <strong>Terjadi kesalahan!</strong>
                    <p class="mb-1">Silakan cek kembali inputan Anda:</p>
                    <ul class="mb-0 ps-4">
                        @foreach ($errors->all() as $error)
                            <li class="mb-1">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert"
                aria-label="Close"></button>
        </div>
    @endif

    <div class=" d-flex justify-content-center align-items-center px-4 pt-5">
        <div class="row w-100 h-100">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Data Keuangan RT. 02 Graha Indah</h5>
                            <div class="d-flex gap-5 align-items-center">
                                <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center">
                                    <label class="me-2">Tampilkan</label>
                                    <select name="per_page" class="form-select w-auto" onchange="this.form.submit()">
                                        @foreach ([10, 25, 50, 100] as $size)
                                            <option value="{{ $size }}"
                                                {{ request('per_page') == $size ? 'selected' : '' }}>
                                                {{ $size }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label class="ms-2">data</label>
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                </form>
                                <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center">
                                    <input type="text" name="search" class="form-control me-2"
                                        placeholder="Cari kategori..." value="{{ request('search') }}">
                                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                            </div>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <table class="table table-striped w-100 nowrap">
                            <thead class="text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan (Rp.)</th>
                                    <th>Total (Rp.)</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($finances as $finance)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($finance->date)->format('d-m-Y') }}</td>
                                        <td>{{ ucfirst($finance->type) }}</td>
                                        <td>{{ $finance->category }}</td>
                                        <td>{{ $finance->item_name ?? '-' }}</td>
                                        <td>{{ $finance->quantity ?? '-' }}</td>
                                        <td>{{ number_format($finance->unit_price ?? 0, 0, ',', '.') }}</td>
                                        <td><strong>{{ number_format($finance->total, 0, ',', '.') }}</strong></td>
                                        <td>{{ $finance->description ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <btn class="btn btn-sm btn-warning">
                                                    <i data-feather="edit"></i>
                                                </btn>
                                                <form action="" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin hapus?')">
                                                        <i data-feather="trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <button type="button" class="btn  btn-success ms-4" data-bs-toggle="modal"
                                    data-bs-target="#modalKeuangan">
                                    Tambah Data
                                </button>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-4">
                                <div class="mb-2">
                                    Menampilkan {{ $finances->firstItem() }} hingga {{ $finances->lastItem() }} dari
                                    {{ $finances->total() }} data
                                </div>
                                {{ $finances->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalKeuangan" tabindex="-1" aria-labelledby="modalKeuanganLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKeuanganLabel">Tambahkan Data Keuangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form action="{{ route('superadmin.finance.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label"> <span class="text-danger">*</span>
                                        Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="date" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label"><span class="text-danger">*</span>
                                        Jenis</label>
                                    <select class="form-select" id="jenis" name="type" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="income">Pemasukan</option>
                                        <option value="expense">Pengeluaran</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kategori" class="form-label"> <span class="text-danger">*</span>
                                        Kategori</label>
                                    <input type="text" class="form-control" id="kategori" name="category"
                                        placeholder="Perlengkapan RT" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="item_name"
                                        placeholder="Kipas Angin">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="quantity"
                                        min="0" value="0">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="harga_satuan" class="form-label">Harga Satuan (Rp)</label>
                                    <input type="text" class="form-control" id="harga_satuan" placeholder="Rp 0"
                                        oninput="formatRupiah(this)">
                                    <input type="hidden" name="unit_price" id="harga_satuan_real">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="description" placeholder="Keperluan acara 17 agustusan"
                                    rows="3"></textarea>
                            </div>
                            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formatRupiah(el) {
            let value = el.value.replace(/[^0-9]/g, '');
            let formatted = '';

            if (value) {
                formatted = 'Rp ' + Number(value).toLocaleString('id-ID');
            }

            el.value = formatted;
            document.getElementById('harga_satuan_real').value = value;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const alertBox = document.getElementById('floatingAlert');
            if (alertBox) {
                setTimeout(() => {
                    const alert = bootstrap.Alert.getOrCreateInstance(alertBox);
                    alert.close();
                }, 4000);
            }
        });

        setTimeout(() => {
            const alert = document.getElementById('autoDismissAlert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);
    </script>
@endsection
