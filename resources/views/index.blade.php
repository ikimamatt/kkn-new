@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
    </div>
</div>

<!-- start row -->
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="row g-3">

            <div class="">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="fs-22 mb-1 fw-semibold">Selamat datang {{ auth()->user()->name }}</div>
                        </div>

                      <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-14 mb-0 me-2 text-black text-justify">
                            SIRAT Sistem Informasi Rukun Tetangga adalah aplikasi berbasis web yang memudahkan pengelolaan
                            administrasi di tingkat RT, mencakup data blok, rumah, kartu keluarga, dan user. Aplikasi ini juga
                            mengelola data keuangan RT, termasuk sumbangan warga dan pengeluaran, serta mencatat kegiatan warga
                            beserta absensinya. Dengan SIRAT, pengurus RT dapat mengakses data secara efisien dan transparan,
                            mendukung pengambilan keputusan yang lebih baik dan meningkatkan komunikasi antara pengurus dan warga.
                        </div>
                    </div>


                    </div>
                </div>
            </div>

            {{-- <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="fs-14 mb-1">Jumlah Pengajuan Surat</div>
                        </div>

                        <div class="d-flex align-items-baseline mb-2">
                            <div class="fs-22 mb-0 me-2 fw-semibold text-black">91.6K</div>

                        </div>

                    </div>
                </div>
            </div> --}}


        </div>
    </div> <!-- end sales -->
</div> <!-- end row -->


@endsection

@section('script')
    <script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>
    @vite(['resources/js/pages/analytics-dashboard.init.js'])
@endsection
