<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - Perpustakaan Multicomp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .auth-card { max-width: 450px; border-radius: 1rem; border: none; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="container d-flex justify-content-center">
    <div class="card auth-card w-100 p-4">
        <div class="card-body">

            <h4 class="fw-bold mb-4 text-center">Buat Password Baru</h4>

            {{-- Pesan Error Validasi Token --}}
            @if(session('error'))
                <div class="alert alert-danger small">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                {{-- Hidden input untuk mengirim token ke controller --}}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Anda</label>
                    <input type="email" name="email" class="form-control text-muted bg-light" value="{{ $email }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ketik ulang password baru" required>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold py-2">Simpan Password Baru</button>
            </form>

        </div>
    </div>
</div>

</body>
</html>
