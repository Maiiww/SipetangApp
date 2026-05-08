@extends('layouts.argon')

@section('title', 'Cetak Laporan')
@section('page-title', 'Cetak Laporan')
@section('breadcrumb', 'Cetak Laporan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Cetak Laporan</h5>
                    <p class="text-sm text-muted">Gunakan halaman ini untuk menyiapkan dan mencetak laporan hasil tangkap.
                    </p>
                    <div class="alert alert-info">
                        Halaman ini masih placeholder. Silakan tambahkan logika cetak laporan sesuai kebutuhan aplikasi
                        Anda.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <p class="mb-2 font-weight-bold">Preview Laporan</p>
                                <p class="text-sm text-muted mb-0">Ringkasan hasil tangkapan dan data statistik akan
                                    ditampilkan di sini sebelum cetak.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary w-100">Cetak Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
