<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('catalog.index') }}">
                <img src="{{ asset('images/MCP.jpg') }}" alt="Logo Perpustakaan Multicomp">
            </a>

            <div class="d-flex align-items-center">
                <a href="{{ route('catalog.all') }}" class="btn btn-sm btn-outline-secondary d-lg-none me-3"><i class="bi bi-grid-3x3-gap-fill"></i> Semua</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-grid-fill"></i> Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-sm btn-outline-danger me-2"><i class="bi bi-person-plus-fill"></i> Mendaftar</a>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                @endauth
            </div>
        </div>
    </nav>
