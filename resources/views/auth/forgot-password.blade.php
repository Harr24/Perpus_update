<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Perpustakaan Multicomp</title>
    <!-- Gunakan Bootstrap 5 CDN jika layout utama belum ada -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .auth-card { max-width: 450px; border-radius: 1rem; border: none; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="container d-flex justify-content-center">
    <div class="card auth-card w-100 p-4">
        <div class="card-body text-center">

            <h4 class="fw-bold mb-3">Lupa Password?</h4>
            <p class="text-muted mb-4 small">Masukkan email yang terdaftar di akun Anda. Kami akan mengirimkan tautan untuk membuat password baru.</p>

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="alert alert-success small text-start">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="text-start">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="contoh@gmail.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Kirim Link Reset</button>
            </form>

            <div class="mt-4">
                <a href="{{ route('login') }}" class="text-decoration-none small text-muted">Kembali ke Halaman Login</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
