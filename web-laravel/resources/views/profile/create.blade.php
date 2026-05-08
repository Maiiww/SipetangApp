@extends('layouts.argon')

@section('title', 'Tambah Karyawan Baru')
@section('page-title', 'Tambah Karyawan Baru')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Karyawan Baru</h5>
                    <p class="text-sm text-muted mb-0">Masukkan data dasar karyawan TPI untuk ditambahkan ke sistem.</p>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">ID Karyawan</label>
                            <input type="text" class="form-control" placeholder="001" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" placeholder="Budi Santoso" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" placeholder="Jl. Merdeka No. 1" />
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select">
                                    <option selected>Laki-laki</option>
                                    <option>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Umur</label>
                                <input type="number" class="form-control" placeholder="30" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Asal TPI</label>
                                <select class="form-select">
                                    <option selected>TPI A</option>
                                    <option>TPI B</option>
                                    <option>TPI C</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('profile') }}" class="btn btn-secondary">Batal</a>
                            <button type="button" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
