@extends('layouts.admin')

@section('content')
    {{-- Tombol Batal dan Kembali --}}
    <div class="mb-6">
        <a href="{{ route('admin.superadmin.members.index') }}" class="text-gray-500 hover:text-gray-900 font-bold text-sm flex items-center gap-2 transition w-fit group">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Batal dan Kembali
        </a>
    </div>

    {{-- Pesan error jika password salah --}}
    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-bold flex items-center gap-3 max-w-2xl mx-auto">
            <svg class="w-6 h-6 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Kotak Peringatan Utama --}}
    <div class="max-w-2xl mx-auto bg-white rounded-[1.5rem] shadow-sm border-t-4 border-rose-600 overflow-hidden">
        <div class="p-8 md:p-10">

            {{-- Ikon Peringatan SVG --}}
            <div class="flex items-center justify-center w-20 h-20 bg-rose-50 rounded-full mx-auto mb-5 border border-rose-100">
                <svg class="w-10 h-10 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <h2 class="text-2xl md:text-3xl font-extrabold text-center text-gray-900 mb-2 tracking-tight">Portal Tindakan Kritis</h2>
            <p class="text-center text-gray-500 mb-8 font-medium">Eksekusi Kenaikan Kelas Massal Anggota Perpustakaan</p>

            {{-- Penjelasan Aturan Main --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 md:p-6 mb-8">
                <h3 class="font-extrabold text-amber-900 mb-3 text-xs uppercase tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    HARAP BACA SEBELUM MELANJUTKAN:
                </h3>
                <ul class="list-none text-amber-800 text-sm space-y-3 font-medium">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        Siswa <strong>Kelas X</strong> akan otomatis diubah menjadi <strong>Kelas XI</strong>.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        Siswa <strong>Kelas XI</strong> akan otomatis diubah menjadi <strong>Kelas XII</strong>.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        Siswa <strong>Kelas XII</strong> akan diubah statusnya menjadi <strong>ALUMNI / Lulus</strong>.
                    </li>
                    <li class="flex items-start gap-2 mt-4 pt-4 border-t border-amber-200/60 text-rose-600">
                        <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        <span><strong>Tindakan ini bersifat PERMANEN dan tidak dapat dibatalkan dari sistem!</strong> Pastikan tahun ajaran baru benar-benar sudah dimulai.</span>
                    </li>
                </ul>
            </div>

            {{-- Tombol Trigger Modal --}}
            <button type="button" onclick="openAuthModal()" class="w-full flex justify-center items-center gap-2 rounded-xl px-6 py-3.5 bg-rose-600 text-sm font-extrabold text-white shadow-sm hover:bg-rose-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 border border-transparent">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Proses Kenaikan Kelas Sekarang
            </button>
        </div>
    </div>

    {{-- MODAL DOUBLE AUTHENTICATION (SUDO MODE) --}}
    <div id="authModal" class="fixed inset-0 z-[9999] hidden">
        {{-- Background Gelap --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-[1.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full border border-gray-100">
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-extrabold text-gray-900">Otorisasi Superadmin</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-4">Untuk mengeksekusi sistem secara massal, masukkan password akun Anda sebagai tanda konfirmasi final.</p>

                                {{-- Form POST Eksekusi --}}
                                <form id="promotionForm" action="{{ route('admin.superadmin.members.promote.all') }}" method="POST" class="m-0">
                                    @csrf
                                    <div class="mb-1">
                                        <input type="password" name="password" id="password" required placeholder="Ketik password Anda di sini..."
                                               class="w-full border border-gray-300 bg-white rounded-xl py-3 px-4 text-sm font-medium focus:ring-4 focus:ring-rose-50 focus:border-rose-500 shadow-sm outline-none transition">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Bawah Modal --}}
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="button" onclick="document.getElementById('promotionForm').submit()" class="w-full inline-flex justify-center items-center rounded-xl border border-transparent px-6 py-2.5 bg-rose-600 text-sm font-bold text-white shadow-sm hover:bg-rose-700 transition">
                        Konfirmasi Final
                    </button>
                    <button type="button" onclick="closeAuthModal()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 px-6 py-2.5 bg-white text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Modal Javascript --}}
    <script>
        const authModal = document.getElementById('authModal');
        const passwordInput = document.getElementById('password');

        function openAuthModal() {
            authModal.classList.remove('hidden');
            // Supaya saat pop up terbuka, kursor otomatis siap ngetik di kotak password
            setTimeout(() => {
                passwordInput.focus();
            }, 100);
        }

        function closeAuthModal() {
            authModal.classList.add('hidden');
            passwordInput.value = ''; // Kosongkan input password saat ditutup
        }

        // Tutup modal jika user klik background gelap di luarnya
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-slate-900/60')) {
                closeAuthModal();
            }
        }
    </script>
@endsection
