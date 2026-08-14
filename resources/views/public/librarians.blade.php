@extends('layouts.public')

@section('title', 'Daftar Pustakawan - Perpustakaan Multicomp')

{{-- BUNGKUS CSS DENGAN @push AGAR MASUK KE <head> --}}
@push('styles')
<style>
    .profile-card {
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .profile-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .profile-details {
        font-size: 0.95rem;
    }
    .profile-details .label {
        font-weight: 600;
        min-width: 80px;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="container py-5">

    <div class="row justify-content-center mb-5">
        <div class="col-lg-10 col-xl-8">
            <div class="mb-3 text-center text-sm-start">
                <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>

            <div class="text-center mt-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-badge fs-1"></i>
                </div>
                <h1 class="display-5 fw-bold" style="color: var(--brand-red);">Profil Pustakawan & Staf</h1>
                <p class="lead text-muted">Kenali lebih dekat tim di balik Perpustakaan SMK Multicomp Depok.</p>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        @forelse ($staff as $person)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100 profile-card">
                    <div class="card-body p-4 d-sm-flex align-items-sm-center text-center text-sm-start">

                        <div class="flex-shrink-0 me-sm-4 mb-3 mb-sm-0">
                            @if($person->profile_photo)
                                <img src="{{ asset('storage/' . $person->profile_photo) }}" alt="Foto {{ $person->name }}" class="profile-photo">
                            @else
                                <div class="profile-photo d-flex align-items-center justify-content-center text-white fs-1 fw-bold mx-auto" style="background: linear-gradient(135deg, var(--brand-red), #e53935);">
                                    {{ strtoupper(substr($person->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="profile-details">
                            <h5 class="fw-bold mb-2 text-dark">{{ $person->name }}</h5>
                            <p class="mb-1 text-muted">
                                <span class="label text-danger">Jabatan:</span>
                                @if($person->role == 'petugas')
                                    Pustakawan
                                @elseif($person->role == 'guru')
                                    Guru
                                @endif
                            </p>
                            <p class="mb-0 text-muted">
                                <span class="label text-danger">Email:</span>
                                <a href="mailto:{{ $person->email }}" class="text-decoration-none text-muted">{{ $person->email }}</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert alert-warning border-0 shadow-sm py-4 rounded-4">
                    <i class="bi bi-info-circle-fill fs-2 d-block mb-2 text-warning"></i>
                    <h5 class="alert-heading fw-bold">Belum Ada Data</h5>
                    <p class="mb-0">Data pustakawan dan staf belum tersedia saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
