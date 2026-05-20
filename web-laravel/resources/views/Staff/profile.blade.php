@extends('layouts.argon')

@section('title', 'Profil')
@section('page-title', 'Profil User')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="mb-4">Informasi Profil</h4>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #666;">Nama</label>
                            <p style="font-size: 16px; color: #333;">{{ Auth::user()->nama ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #666;">No. Induk</label>
                            <p style="font-size: 16px; color: #333;">{{ Auth::user()->no_induk ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #666;">Username</label>
                            <p style="font-size: 16px; color: #333;">{{ Auth::user()->username ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #666;">Jenis Kelamin</label>
                            <p style="font-size: 16px; color: #333;">{{ Auth::user()->jenis_kelamin ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #666;">No. Telepon</label>
                            <p style="font-size: 16px; color: #333;">{{ Auth::user()->no_telepon ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #666;">Alamat</label>
                            <p style="font-size: 16px; color: #333;">{{ Auth::user()->alamat ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #666;">Role</label>
                            <p style="font-size: 16px; color: #333;">
                                <span class="badge"
                                    style="background: #0d2640; color: white; padding: 6px 12px;">{{ Auth::user()->role ?? '-' }}</span>
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; color: #666;">Wilayah</label>
                            <p style="font-size: 16px; color: #333;">{{ Auth::user()->wilayah ?? '-' }}</p>
                        </div>

                        <div class="button-group">
                            <a href="{{ route('staff.dashboard') }}" class="btn btn-secondary" style="margin-right: 10px;">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card" style="background: #f8f9fa; border: none; text-align: center; padding: 30px;">
                            <div
                                style="width: 120px; height: 120px; background: #0d2640; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="fas fa-user" style="font-size: 60px; color: white;"></i>
                            </div>
                            <h5 style="color: #0d2640; margin-bottom: 10px;">{{ Auth::user()->nama ?? 'User' }}</h5>
                            <p style="color: #999; font-size: 13px;">{{ Auth::user()->username ?? '-' }}</p>
                            <hr style="margin: 20px 0;">
                            <p style="font-size: 12px; color: #999;">
                                <strong>Status:</strong> Aktif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
