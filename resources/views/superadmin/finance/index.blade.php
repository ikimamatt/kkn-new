@extends('layouts.vertical', ['title' => 'Keuangan RT'])

@section('content')
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
                                    @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
                                        <th>Aksi</th>
                                    @endif
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
                                        @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
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
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
                                    <button class="btn btn-success ms-4">Tambah Data</button>
                                @endif
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
    </div>
@endsection
