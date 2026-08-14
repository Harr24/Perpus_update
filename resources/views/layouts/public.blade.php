<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Multicomp')</title>

    {{-- CSS Links --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Style dasar & untuk sticky footer --}}
    <style>
        :root { --brand-red: #c62828; }
        html, body {
            max-width: 100vw;
            overflow-x: hidden !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Paksa Bootstrap agar tidak menambah ruang kosong saat sidebar dibuka */
            padding-right: 0 !important;
            overflow-y: auto !important;
        }

        main {
            flex-grow: 1;
        }

        /* Styling tambahan untuk Offcanvas Sidebar */
        .offcanvas-header { background-color: var(--brand-red); color: white; }
        .offcanvas-header .btn-close { filter: invert(1); }
        .sidebar-link { color: #495057; font-weight: 500; }
        .sidebar-link:hover { background-color: #f8f9fa; color: var(--brand-red); }
        .sidebar-link.active { background-color: #f8d7da; color: var(--brand-red); font-weight: 700; border-radius: 8px; }

        /* Tombol Hamburger Custom */
        .custom-toggler {
            background: none;
            border: none;
            font-size: 2rem;
            color: var(--brand-red);
            padding: 0;
            margin-right: 15px;
            transition: transform 0.3s ease;
        }
        .custom-toggler:hover {
            transform: scale(1.1);
        }

        /* 1. Atur lebar sidebar agar tidak 100% di HP */
        .offcanvas-start {
            width: 80% !important;
            max-width: 300px !important;
            will-change: transform;
            box-shadow: 4px 0 25px rgba(0,0,0,0.15);
            border-right: none !important;
        }

        /* 2. Sulap Backdrop (Latar Belakang Gelap) menjadi Blur */
        .offcanvas-backdrop.show {
            opacity: 1 !important;
            background-color: rgba(0, 0, 0, 0.4) !important;
            backdrop-filter: blur(5px) !important;
            -webkit-backdrop-filter: blur(5px) !important;
        }

        /* Efek hover untuk link di footer */
        .hover-white:hover { color: white !important; }
    </style>
    @stack('styles')
</head>
<body>
    <div id="public-layout" class="d-flex flex-column min-vh-100">

        {{-- Navigasi Publik --}}
        <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-2">
            <div class="container">

                {{-- Tombol Hamburger --}}
                <button class="custom-toggler d-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#publicSidebar" aria-controls="publicSidebar" aria-label="Buka Menu">
                    <i class="bi bi-list"></i>
                </button>

                {{-- Logo & Teks --}}
                <a class="navbar-brand fw-bold me-auto d-flex align-items-center" href="{{ route('catalog.index') }}" style="color: #c62828;">
                    <img src="{{ asset('images/MCP.jpg') }}" alt="Logo Multicomp" style="height: 40px; width: auto; object-fit: contain;">
                    <span class="d-none d-sm-inline ms-2 fs-5">Perpustakaan</span>
                </a>

                <div class="d-flex align-items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-danger fw-bold px-3">
                            <i class="bi bi-grid-fill me-1"></i> Dashboard
                        </a>
                    @else
                        {{-- TOMBOL DAFTAR --}}
                        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-danger fw-bold px-3 me-2">
                            <i class="bi bi-person-plus-fill d-inline d-sm-none"></i>
                            <span class="d-none d-sm-inline">Daftar</span>
                        </a>

                        <a href="{{ route('login') }}" class="btn btn-sm btn-danger fw-bold px-3">
                            <i class="bi bi-box-arrow-in-right d-inline d-sm-none"></i>
                            <span class="d-none d-sm-inline">Login</span>
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- ========================================================= --}}
        {{-- PERBAIKAN 2: Tambah data-bs-scroll="true" agar layar diam --}}
        {{-- ========================================================= --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="publicSidebar" aria-labelledby="publicSidebarLabel" data-bs-scroll="true" data-bs-backdrop="true">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold" id="publicSidebarLabel">
                    <i class="bi bi-compass-fill me-2"></i> Navigasi Menu
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column">

                {{-- Form Pencarian Khusus Layar Kecil (Mobile) --}}
                <form action="{{ route('catalog.all') }}" method="GET" class="d-block d-lg-none mb-4">
                    <div class="input-group shadow-sm">
                        <input type="search" name="search" class="form-control" placeholder="Cari buku..." value="{{ request('search') }}">
                        <button class="btn btn-danger" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                {{-- Menu Link Sidebar Utama --}}
                <div class="list-group list-group-flush mb-4">
                    <a href="{{ route('catalog.index') }}" class="list-group-item list-group-item-action border-0 py-3 sidebar-link {{ request()->routeIs('catalog.index') ? 'active' : '' }}">
                        <i class="bi bi-house-door me-3 fs-5 align-middle"></i> Beranda
                    </a>
                    <a href="{{ route('catalog.all') }}" class="list-group-item list-group-item-action border-0 py-3 sidebar-link {{ request()->routeIs('catalog.all') ? 'active' : '' }}">
                        <i class="bi bi-journals me-3 fs-5 align-middle"></i> Katalog Buku
                    </a>
                    <a href="{{ route('catalog.materials.all') }}" class="list-group-item list-group-item-action border-0 py-3 sidebar-link {{ request()->routeIs('catalog.materials.all') ? 'active' : '' }}">
                        <i class="bi bi-play-btn me-3 fs-5 align-middle"></i> Materi Belajar
                    </a>
                    <a href="{{ route('catalog.librarians') }}" class="list-group-item list-group-item-action border-0 py-3 sidebar-link {{ request()->routeIs('catalog.librarians') ? 'active' : '' }}">
                        <i class="bi bi-person-badge me-3 fs-5 align-middle"></i> Daftar Pustakawan
                    </a>

                    {{-- Menu Tambahan (Jadwal & Gamifikasi) --}}
                    <hr class="my-2 border-secondary opacity-25">
                    <div class="px-3 py-2 text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Pintasan Beranda</div>

                    <a href="{{ url('/#jadwal-piket') }}" class="list-group-item list-group-item-action border-0 py-3 sidebar-link">
                        <i class="bi bi-calendar3 me-3 fs-5 align-middle"></i> Jadwal Piket
                    </a>
                    <a href="{{ url('/#peringkat-pembaca') }}" class="list-group-item list-group-item-action border-0 py-3 sidebar-link">
                        <i class="bi bi-trophy me-3 fs-5 align-middle"></i> Peringkat Peminjam
                    </a>
                </div>

                {{-- Informasi Ekstra di Bawah Sidebar --}}
                <div class="mt-auto bg-light p-4 rounded-3 text-center border">
                    <i class="bi bi-info-circle text-danger fs-3 mb-2 block"></i>
                    <h6 class="fw-bold mb-1">Butuh Bantuan?</h6>
                    <p class="text-muted small mb-0">Temui petugas perpustakaan di jam kerja (08:00 - 14:00).</p>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <main>
            @yield('content')
        </main>

        {{-- Footer Gelap --}}
        <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-4 mb-4">
                         <h5 class="fw-bold mb-3 d-flex align-items-center">
                            <img src="{{ asset('images/MCP.jpg') }}" alt="Logo Multicomp" style="height: 30px; width: auto; object-fit: contain; border-radius: 4px;" class="me-2 bg-white p-1">
                            Perpustakaan
                        </h5>
                        <p class="small text-white-50">Sistem informasi ini dirancang untuk memudahkan siswa dan guru dalam mengakses dan meminjam koleksi buku.</p>
                    </div>
                    <div class="col-md-4 col-lg-4 mb-4">
                        <h5 class="fw-bold mb-3">Tautan Cepat</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ route('catalog.index') }}" class="text-white-50 text-decoration-none hover-white">Beranda</a></li>
                            <li class="mb-2"><a href="{{ route('catalog.all') }}" class="text-white-50 text-decoration-none hover-white">Katalog Buku</a></li>
                            <li class="mb-2"><a href="{{ route('catalog.materials.all') }}" class="text-white-50 text-decoration-none hover-white">Materi Belajar</a></li>
                            <li class="mb-2"><a href="{{ route('catalog.librarians') }}" class="text-white-50 text-decoration-none hover-white">Pustakawan</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-lg-4 mb-4">
                        <h5 class="fw-bold mb-3">Cari Koleksi</h5>
                        <form action="{{ route('catalog.all') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci...">
                                <button class="btn btn-danger" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr style="color: #6c757d;">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="small text-white-50 mb-0">&copy; {{ date('Y') }} SMK Multicomp. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
