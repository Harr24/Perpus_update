@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Genre</h2>
                <p class="text-gray-500 mt-1 font-medium">Kelola kategori dan genre buku yang ada di perpustakaan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali
                </a>
                <a href="{{ route('admin.petugas.genres.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-emerald-700 transition shadow-sm hover:shadow-md text-sm">
                    <span>➕</span> Tambah Genre
                </a>
            </div>
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

        {{-- Kontainer Tabel --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider w-16 text-center">No</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center w-24">Icon</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kode Genre</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nama Genre</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($genres as $genre)
                            <tr class="hover:bg-gray-50/80 transition duration-200">

                                {{-- Nomor --}}
                                <td class="px-6 py-4 text-sm font-bold text-gray-400 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Icon --}}
                                <td class="px-6 py-4 flex justify-center">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-50 border border-gray-200 flex items-center justify-center shrink-0 shadow-sm">
                                        @if($genre->icon)
                                            <img src="{{ asset('storage/' . $genre->icon) }}" alt="{{ $genre->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">N/A</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kode Genre --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold font-mono bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $genre->genre_code }}
                                    </span>
                                </td>

                                {{-- Nama Genre --}}
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                    {{ $genre->name }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.petugas.genres.edit', $genre->id) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg text-xs font-bold transition border border-amber-200">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.petugas.genres.destroy', $genre->id) }}" method="POST" class="form-delete-genre m-0" data-name="{{ $genre->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition border border-rose-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-5xl mb-4 opacity-50">📂</span>
                                        <h3 class="text-lg font-bold text-gray-900">Data Kosong</h3>
                                        <p class="text-gray-500 mt-1 mb-4">Belum ada data genre yang ditambahkan.</p>
                                        <a href="{{ route('admin.petugas.genres.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-emerald-700 transition shadow-sm">
                                            Tambah Genre Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert2 untuk Konfirmasi Hapus --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.form-delete-genre');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const genreName = this.dataset.name;

                    Swal.fire({
                        title: 'Hapus Genre?',
                        html: `Anda yakin ingin menghapus genre <strong>"${genreName}"</strong>?<br><span class="text-sm text-rose-500">Tindakan ini tidak dapat dibatalkan.</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48', // Rose-600
                        cancelButtonColor: '#6b7280', // Gray-500
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
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
