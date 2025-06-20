@extends('layouts.vertical', ['title' => 'Keuangan RT'])

@section('css')
    <style>
        .pagination {
            flex-wrap: wrap;
            justify-content: center
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @elseif ($errors->any())
        <x-alert type="success">
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
        </x-alert>
    @endif

    <div class=" d-flex justify-content-center align-items-center px-0 px-lg-4 pt-5">
        <div class="row w-100 h-100">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Data Keuangan <span class="d-block">RT. 02 Graha
                                    Indah</span></h5>
                            <div class="d-flex align-items-center">
                                <form method="GET" action="{{ url()->current() }}"
                                    class="d-flex flex-column flex-sm-row align-items-center gap-2 gap-sm-4">
                                    <div class="d-flex align-items-center">
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
                                    </div>

                                    {{-- Filter bulan --}}
                                    <div class="d-flex align-items-center">
                                        <label class="me-2">Bulan</label>
                                        <select name="month" class="form-select w-auto" onchange="this.form.submit()">
                                            <option value="">Semua</option>
                                            @foreach (range(1, 12) as $m)
                                                <option value="{{ $m }}"
                                                    {{ request('month') == $m ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body pt-0 pt-xl-2">
                        <div style="overflow-x: auto; max-width: 100%;">
                            <table class="table table-striped table-responsive nowrap">
                                <thead class="text-center">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan (Rp.)</th>
                                        <th>Total (Rp.)</th>
                                        <th>Saldo (Rp.)</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($finances as $finance)
                                        <tr class="align-middle">
                                            <td>{{ \Carbon\Carbon::parse($finance->date)->format('d-m-Y') }}</td>
                                            <td class="{{ $finance->type === 'income' ? 'text-primary' : 'text-danger' }}">
                                                <strong>{{ ucfirst($finance->type) }}</strong>
                                            </td>
                                            <td>{{ $finance->category }}</td>
                                            <td>{{ $finance->item_name ?? '-' }}</td>
                                            <td>{{ $finance->quantity ?? '-' }}</td>
                                            <td>{{ number_format($finance->unit_price ?? 0, 0, ',', '.') }}</td>
                                            <td><strong>{{ number_format($finance->total, 0, ',', '.') }}</strong></td>
                                            <td><strong>{{ number_format($finance->running_balance, 0, ',', '.') }}</strong>
                                            </td>
                                            <td>{{ $finance->description ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#modalKeuangan" data-id="{{ $finance->id }}"
                                                        data-date="{{ $finance->date }}" data-type="{{ $finance->type }}"
                                                        data-category="{{ $finance->category }}"
                                                        data-item_name="{{ $finance->item_name }}"
                                                        data-quantity="{{ $finance->quantity }}"
                                                        data-unit_price="{{ $finance->unit_price }}"
                                                        data-description="{{ $finance->description }}">
                                                        <i data-feather="edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDelete-{{ $finance->id }}">
                                                        <i data-feather="trash"></i>
                                                    </button>
                                                </div>

                                                {{-- Delete Modal --}}
                                                <x-confirm-delete-modal id="confirmDelete-{{ $finance->id }}"
                                                    :action="route('superadmin.finance.destroy', $finance->id)"
                                                    message="Yakin ingin menghapus item '{{ $finance->item_name }}'?" />
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="d-flex justify-content-between align-items-center mt-3 flex-column-reverse flex-md-row gap-2 gap-md-0">
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-primary ms-xl-4 ms-0" data-bs-toggle="modal"
                                    data-bs-target="#modalKeuangan">
                                    Tambah Data
                                </button>
                                <a href="{{ route('finance.export') }}"class="btn btn-success">Export Excel</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-center flex-column me-xl-4 me-0">
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

        <!-- Modal Tambah Data-->
        @include('superadmin.finance.modal-finance')
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
    </script>
@endsection
