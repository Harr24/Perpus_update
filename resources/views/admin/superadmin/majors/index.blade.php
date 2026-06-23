@extends('layouts.admin')

@section('title', 'Manajemen Jurusan')

@section('content')
    {{-- Header Halaman & Tombol Aksi --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Jurusan</h2>
            <p class="text-gray-500 mt-1 font-medium">Kelola daftar jurusan akademik yang tersedia di sekolah.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
            <a href="{{ route('admin.superadmin.majors.create') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white font-bold py-2.5 px-4 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md text-sm">
                <span>➕</span> Tambah Jurusan
            </a>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-bold flex items-center gap-3">
            <span class="text-xl">⚠️</span> {{ session('error') }}
        </div>
    @endif

    {{-- Kontainer Tabel --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden flex-1 flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nama Jurusan</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($majors as $major)
                        <tr class="hover:bg-gray-50/50 transition duration-200">
                            {{-- Kolom No --}}
                            <td class="px-6 py-4 text-sm font-bold text-gray-400">
                                {{ $loop->iteration }}
                            </td>

                            {{-- Kolom Nama Jurusan --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                        🎓
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $major->name }}</h4>
                                </div>
                            </td>

                            {{-- Kolom Tanggal --}}
                            <td class="px-6 py-4 text-sm font-medium text-gray-500">
                                {{ $major->created_at->format('d M Y') }}
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.superadmin.majors.edit', $major) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-sm font-bold transition">
                                    Edit
                                </a>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.superadmin.majors.destroy', $major) }}', '{{ addslashes($major->name) }}')" class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg text-sm font-bold transition">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-4xl mb-3">🏫</span>
                                    <h3 class="text-lg font-bold text-gray-900">Belum ada jurusan</h3>
                                    <p class="text-gray-500 mt-1">Silakan tambahkan data jurusan baru untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($majors->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $majors->links() }}
            </div>
        @endif
    </div>

    {{-- ================================================= --}}
    {{-- MODAL HAPUS JURUSAN --}}
    {{-- ================================================= --}}
    <div id="deleteModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full border border-gray-100">
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                            <span class="text-rose-600 text-xl">⚠️</span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-extrabold text-gray-900">Hapus Jurusan</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus jurusan <strong id="majorName" class="text-gray-800"></strong>? <br><br> <span class="text-rose-600 font-bold bg-rose-50 px-2 py-0.5 rounded">Catatan:</span> Sistem akan menolak penghapusan jika jurusan ini masih digunakan oleh siswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                    <form id="deleteForm" action="" method="POST" class="m-0">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 bg-rose-600 text-base font-bold text-white shadow-sm hover:bg-rose-700 focus:outline-none sm:w-auto sm:text-sm transition">
                            Ya, Hapus
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-gray-300 px-4 py-2 bg-white text-base font-bold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Modal --}}
    <script>
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const majorNameEl = document.getElementById('majorName');

        function openDeleteModal(url, name) {
            deleteForm.action = url;
            majorNameEl.textContent = name;
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        // Tutup modal jika klik di luar area kotak modal
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-slate-900/60')) {
                closeDeleteModal();
            }
        }
    </script>
@endsection
