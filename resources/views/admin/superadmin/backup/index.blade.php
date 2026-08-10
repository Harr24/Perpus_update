@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pemeliharaan Sistem</h2>
            <p class="text-gray-500 mt-1 font-medium">Amankan data perpustakaan dengan mengunduh salinan database.</p>
        </div>
    </div>

    {{-- Error Alert --}}
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Card Backup --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 md:p-12 text-center flex flex-col items-center">

            {{-- Icon Database --}}
            <div class="w-24 h-24 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-6 shadow-sm border border-indigo-100">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-4">Download Salinan SQL</h3>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto leading-relaxed text-sm md:text-base">
                Fitur ini akan mengekspor seluruh data sistem saat ini ke dalam sebuah file <strong>.sql</strong>.
                Data yang dicadangkan meliputi informasi buku, data anggota, riwayat sirkulasi, pengaturan hari libur, dan denda.
                Simpan file ini di tempat yang aman untuk keperluan pemulihan (restore) jika diperlukan.
            </p>

            {{-- Tombol Download dengan Animasi Loading --}}
            <a href="{{ route('admin.superadmin.backup.download') }}"
               onclick="this.innerHTML='<svg class=\'animate-spin w-5 h-5 mr-2\' fill=\'none\' viewBox=\'0 0 24 24\'><circle class=\'opacity-25\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'></circle><path class=\'opacity-75\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'></path></svg> Sedang Mengekspor...'; this.classList.add('opacity-75', 'cursor-not-allowed', 'pointer-events-none');"
               class="inline-flex items-center px-8 py-3.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition shadow-lg hover:shadow-xl text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download Backup Sekarang
            </a>

            <p class="mt-6 text-xs text-gray-400 font-medium">Proses unduh mungkin memakan waktu beberapa detik tergantung besarnya data.</p>
        </div>
    </div>
</div>
@endsection
