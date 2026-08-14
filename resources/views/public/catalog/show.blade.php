@extends('layouts.public')

@section('title', $book->title . ' - Katalog Perpustakaan')

@push('styles')
    <style>
        .cover-image {
            width: 100%;
            max-width: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .book-synopsis {
            white-space: pre-wrap;
            line-height: 1.6;
            color: #495057;
        }
    </style>
@endpush

@section('content')
    <div class="container my-5">

        {{-- Tombol Kembali --}}
        <div class="mb-4">
            <a href="{{ route('catalog.all') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
            </a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Kartu Utama Detail Buku --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-lg-5">
                <div class="row">
                    {{-- Kolom Kiri: Gambar Sampul --}}
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://placehold.co/300x450/E91E63/FFFFFF?text=No+Cover' }}"
                             class="cover-image" alt="Sampul {{ $book->title }}">
                    </div>

                    {{-- Kolom Kanan: Detail Buku --}}
                    <div class="col-md-8">
                        <h1 class="h2 fw-bold" style="color: var(--brand-red);">{{ $book->title }}</h1>
                        <p class="text-muted fs-5 mb-3">oleh <strong>{{ $book->author }}</strong></p>

                        <div class="mb-4">
                            <span class="badge bg-danger me-2 py-2 px-3">{{ $book->genre->name }}</span>

                            @switch($book->book_type)
                                @case('paket')
                                    <span class="badge bg-info text-dark py-2 px-3"><i class="bi bi-box-seam me-1"></i> Buku Paket</span>
                                    @break
                                @case('laporan')
                                    <span class="badge bg-secondary py-2 px-3"><i class="bi bi-journal-text me-1"></i> Buku Laporan</span>
                                    @break
                                @case('reguler')
                                    <span class="badge bg-primary py-2 px-3"><i class="bi bi-book me-1"></i> Buku Reguler</span>
                                    @break
                            @endswitch
                        </div>

                        <div class="bg-light p-3 rounded-3 mb-4 border">
                            <h6 class="fw-bold mb-1"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Lokasi Rak:</h6>
                            <p class="mb-0 text-muted ms-4">{{ optional($book->shelf)->name ?? 'Belum Diatur' }}</p>
                        </div>

                        {{-- Menampilkan Sinopsis --}}
                        @if ($book->synopsis)
                            <h5 class="fw-bold"><i class="bi bi-card-text me-2 text-danger"></i>Sinopsis</h5>
                            <p class="book-synopsis mt-2">{!! nl2br(e($book->synopsis)) !!}</p>
                        @endif
                    </div>
                </div>

                <hr class="my-5" style="border-style: dashed;">

                {{-- AREA LOGIKA PEMINJAMAN (Hanya untuk User Login) --}}
                @auth
                    @php
                        // Cek HANYA apakah buku ini adalah 'paket'
                        $isBookPackage = ($book->book_type == 'paket');
                    @endphp

                    {{-- Form Pinjam Buku Paket untuk Guru --}}
                    @if(Auth::user()->role == 'guru' && $isBookPackage)
                        <div class="card bg-light border-2 border-danger border-opacity-25 mb-5 rounded-4 shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="h5 fw-bold text-danger"><i class="bi bi-person-workspace me-2"></i> Pinjam Buku Paket (Khusus Guru)</h3>
                                <p class="small text-muted mb-4">Anda dapat meminjam beberapa eksemplar buku ini sekaligus untuk kebutuhan kelas.</p>

                                <form action="{{ route('borrow.store.bulk') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <div class="row align-items-end">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label for="quantity" class="form-label fw-semibold">Jumlah yang ingin dipinjam:</label>
                                            <div class="input-group">
                                                <input type="number" name="quantity" id="quantity" class="form-control"
                                                       min="1" max="{{ $book->available_copies_count }}"
                                                       placeholder="Maks: {{ $book->available_copies_count }}" required>
                                                <span class="input-group-text">Buku</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-danger w-100 fw-bold py-2">
                                                <i class="bi bi-box-arrow-down me-2"></i> Ajukan Pinjaman Massal
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-text mt-2">
                                        Saat ini tersedia <strong>{{ $book->available_copies_count }}</strong> eksemplar untuk dipinjam.
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- Tabel Pinjam Satuan --}}
                    <h3 class="h5 fw-bold mb-3"><i class="bi bi-list-ol me-2 text-danger"></i> Daftar Salinan Buku</h3>
                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Kode Eksemplar</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($book->copies as $copy)
                                    <tr>
                                        <td class="px-4 fw-medium font-monospace">{{ $copy->book_code }}</td>
                                        <td class="px-4">
                                            @if($copy->status == 'tersedia')
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success"><i class="bi bi-check-circle-fill me-1"></i> Tersedia</span>
                                            @elseif($copy->status == 'pending')
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning"><i class="bi bi-hourglass-split me-1"></i> Sedang Diajukan</span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary"><i class="bi bi-lock-fill me-1"></i> Dipinjam</span>
                                            @endif
                                        </td>
                                        <td class="px-4">
                                            @if($copy->status == 'tersedia')
                                                <form action="{{ route('borrow.store', $copy) }}" method="POST" onsubmit="return confirm('Anda yakin ingin mengajukan pinjaman untuk buku ini?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-bold">Pinjam</button>
                                                </form>
                                            @else
                                                <button class="btn btn-light text-muted btn-sm w-100" disabled>Tidak Tersedia</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                            Tidak ada salinan buku yang tersedia saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endauth

                {{-- JIKA USER BELUM LOGIN --}}
                @guest
                    <div class="alert alert-danger bg-opacity-10 border-danger border-opacity-25 mt-4 text-center p-4 rounded-4">
                        <i class="bi bi-shield-lock fs-1 text-danger d-block mb-2"></i>
                        <h5 class="fw-bold text-danger">Akses Terbatas</h5>
                        <p class="mb-3">Anda harus memiliki akun aktif untuk dapat meminjam buku ini.</p>
                        <a href="{{ route('login') }}" class="btn btn-danger px-4 rounded-pill fw-bold">Login Sekarang</a>
                    </div>
                @endguest

            </div>
        </div>
    </div>
@endsection
