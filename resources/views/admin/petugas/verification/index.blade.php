@extends('layouts.admin')

@section('content')
    {{-- Header Halaman --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Verifikasi Pendaftar</h2>
            <p class="text-gray-500 mt-1 font-medium">Tinjau dan setujui akun siswa baru yang mendaftar di sistem.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
            <span>⬅️</span> Kembali
        </a>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
            <span class="text-xl">⚠️</span> {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Verifikasi --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nama & Email</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">NISN</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Kartu Pelajar</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pendingUsers as $student)
                        <tr class="hover:bg-gray-50/50 transition duration-200">

                            {{-- Nama dan Email --}}
                            <td class="px-6 py-4">
                                <h4 class="text-sm font-bold text-gray-900">{{ $student->name }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $student->email }}</p>
                            </td>

                            {{-- NISN --}}
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold font-mono border border-gray-200">
                                    {{ $student->nis ?? 'N/A' }}
                                </span>
                            </td>

                            {{-- Kelas & Jurusan --}}
                            <td class="px-6 py-4 text-sm font-bold text-gray-700">
                                {{ $student->class }} {{ $student->major }}
                            </td>

                            {{-- Foto Kartu Pelajar --}}
                            <td class="px-6 py-4 text-center">
                                @if($student->student_card_photo)
                                    <a href="{{ Storage::url($student->student_card_photo) }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-bold transition border border-blue-100">
                                        <span>📸</span> Lihat Foto
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-gray-50 text-gray-400 rounded-lg text-xs font-bold border border-gray-100 italic">
                                        Kosong
                                    </span>
                                @endif
                            </td>

                            {{-- Tombol Aksi (ACC / Tolak) --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Form ACC --}}
                                    <form action="{{ route('admin.petugas.verification.approve', $student) }}" method="POST" class="form-confirm-acc m-0">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-lg text-xs font-bold transition shadow-sm">
                                            ✅ Setujui
                                        </button>
                                    </form>

                                    {{-- Form Tolak --}}
                                    <form action="{{ route('admin.petugas.verification.reject', $student) }}" method="POST" class="form-confirm-reject m-0">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg text-xs font-bold transition border border-rose-100 shadow-sm">
                                            ❌ Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-4xl mb-3">😴</span>
                                    <h3 class="text-lg font-bold text-gray-900">Belum ada pendaftar baru</h3>
                                    <p class="text-gray-500 mt-1">Saat ini tidak ada siswa yang menunggu untuk diverifikasi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Memastikan SweetAlert dimuat --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Logika Konfirmasi ACC
            const accForms = document.querySelectorAll('.form-confirm-acc');
            accForms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Setujui Pendaftar?',
                        text: "Pastikan data NISN dan Kelas sudah sesuai.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#059669', // Emerald-600
                        cancelButtonColor: '#6b7280', // Gray-500
                        confirmButtonText: 'Ya, Setujui!',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem' // Biar agak membulat
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Logika Konfirmasi Tolak
            const rejectForms = document.querySelectorAll('.form-confirm-reject');
            rejectForms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Tolak Pendaftar?',
                        text: "Tindakan ini akan menghapus data pendaftaran siswa.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48', // Rose-600
                        cancelButtonColor: '#6b7280', // Gray-500
                        confirmButtonText: 'Ya, Tolak!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

        });
    </script>
@endpush
