@extends('layouts.admin')

@section('content')
    {{-- Header Halaman & Tombol Aksi --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Anggota</h2>
            <p class="text-gray-500 mt-1 font-medium">Lihat, cari, edit, atau hapus data siswa dan guru.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            {{-- Tombol Hapus Massal (Siswa Lulus) --}}
            @if(isset($graduatedCount) && $graduatedCount > 0)
                <button onclick="openBulkDeleteModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 text-rose-600 border border-rose-100 rounded-xl font-bold shadow-sm hover:bg-rose-100 transition text-sm">
                    <span>🧹</span> Bersihkan Siswa Lulus ({{ $graduatedCount }})
                </button>
            @endif

            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>
    </div>

    {{-- Pesan Sukses & Error --}}
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

    {{-- Kontainer Utama --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">

        {{-- Filter & Search Bar --}}
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form action="{{ route('admin.superadmin.members.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">

                {{-- Dropdown Filter --}}
                <div class="w-full md:w-auto flex-shrink-0">
                    <select name="filter_role" onchange="this.form.submit()" class="w-full border border-gray-200 bg-white rounded-xl text-sm font-bold text-gray-700 py-2.5 px-4 focus:ring-slate-50 focus:border-slate-500 cursor-pointer shadow-sm outline-none transition">
                        <option value="">Semua Anggota</option>
                        <option value="siswa_aktif" {{ request('filter_role') == 'siswa_aktif' ? 'selected' : '' }}>Siswa Aktif</option>
                        <option value="siswa_lulus" {{ request('filter_role') == 'siswa_lulus' ? 'selected' : '' }}>Siswa Lulus (Alumni)</option>
                        <option value="guru" {{ request('filter_role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="petugas" {{ request('filter_role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                </div>

                {{-- Input Pencarian --}}
                <div class="flex w-full md:w-auto items-center">
                    <input type="text" name="search" placeholder="Cari nama, email, atau NIS..." value="{{ request('search') }}"
                           class="border border-r-0 border-gray-200 bg-white rounded-l-xl w-full md:w-72 py-2.5 px-4 text-sm font-medium focus:ring-slate-50 focus:border-slate-500 shadow-sm outline-none transition">
                    <button type="submit" class="bg-slate-900 text-white font-bold py-2.5 px-5 rounded-r-xl hover:bg-slate-800 transition shadow-sm text-sm border border-transparent">
                        Cari
                    </button>

                    {{-- Tombol Reset (Muncul jika sedang filter) --}}
                    @if(request('search') || request('filter_role'))
                        <a href="{{ route('admin.superadmin.members.index') }}" class="text-rose-500 hover:text-rose-600 text-sm font-bold ml-4 transition underline underline-offset-2">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead class="bg-white border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Info Anggota</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">ID / NIS</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kelas / Mapel</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Role & Status</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse ($members as $member)
                        <tr class="hover:bg-gray-50/80 transition duration-200">

                            {{-- Info Anggota (Nama & Email) --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm overflow-hidden shrink-0 border border-gray-200 shadow-sm">
                                        @if($member->profile_photo)
                                            <img src="{{ Storage::url($member->profile_photo) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900">{{ $member->name }}</h4>
                                        <p class="text-[11px] font-medium text-gray-500 mt-0.5">{{ $member->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- ID / NIS --}}
                            <td class="px-6 py-4">
                                @if ($member->role == 'siswa')
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-lg text-[11px] font-bold font-mono border border-gray-200">
                                        {{ $member->nis ?? '-' }}
                                    </span>
                                @else
                                    <span class="text-gray-400 font-bold">-</span>
                                @endif
                            </td>

                            {{-- Kelas / Mapel --}}
                            <td class="px-6 py-4 text-sm font-bold text-gray-700">
                                @if ($member->role == 'siswa')
                                    @if ($member->class == 'Lulus')
                                        <span class="px-2.5 py-1 bg-slate-800 text-white rounded-lg text-[10px] font-bold tracking-widest uppercase shadow-sm">
                                            ALUMNI / LULUS
                                        </span>
                                    @elseif (!empty($member->class) && !empty($member->major))
                                        {{ $member->class }} - {{ $member->major }}
                                    @elseif (!empty($member->class_name))
                                        {{ $member->class_name }}
                                    @else
                                        <span class="text-[11px] text-gray-400 italic font-medium">Siswa Aktif</span>
                                    @endif
                                @elseif ($member->role == 'guru')
                                    {{ $member->subject ?? 'Guru Mapel' }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Role & Status --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1.5 items-start">
                                    {{-- Badge Role --}}
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest border
                                        @if($member->role == 'siswa') bg-indigo-50 text-indigo-700 border-indigo-100
                                        @elseif($member->role == 'guru') bg-rose-50 text-rose-700 border-rose-100
                                        @elseif($member->role == 'petugas') bg-emerald-50 text-emerald-700 border-emerald-100
                                        @else bg-slate-100 text-slate-700 border-slate-200 @endif">
                                        {{ $member->role }}
                                    </span>

                                    {{-- Badge Status --}}
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest border
                                        @if($member->account_status == 'active') bg-emerald-50 text-emerald-700 border-emerald-100
                                        @else bg-amber-50 text-amber-700 border-amber-100 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full @if($member->account_status == 'active') bg-emerald-500 @else bg-amber-500 @endif"></span>
                                        {{ $member->account_status }}
                                    </span>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.superadmin.members.show', $member->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-[11px] font-bold transition border border-blue-100" title="Detail">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.superadmin.members.edit', $member->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-[11px] font-bold transition border border-amber-100" title="Edit">
                                        Edit
                                    </a>
                                    <button type="button" onclick="openDeleteModal('{{ route('admin.superadmin.members.destroy', $member->id) }}', '{{ addslashes($member->name) }}')" class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg text-[11px] font-bold transition border border-rose-100" title="Hapus">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-5xl mb-4 opacity-50">👥</span>
                                    <h3 class="text-lg font-bold text-gray-900">Tidak ada data</h3>
                                    <p class="text-gray-500 mt-1">Data anggota tidak ditemukan atau kosong.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ========================================================== --}}
        {{-- 🔥 PERBAIKAN PAGINATION (TAMPILAN RAPI DENGAN TAILWIND) 🔥 --}}
        {{-- ========================================================== --}}
        @if ($members->hasPages())
            <div class="p-6 border-t border-gray-100 bg-white">
                {{ $members->withQueryString()->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

    {{-- ================================================= --}}
    {{-- MODAL HAPUS SATUAN --}}
    {{-- ================================================= --}}
    <div id="deleteModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-[1.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full border border-gray-100">
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                            <span class="text-rose-600 text-xl">⚠️</span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-extrabold text-gray-900">Hapus Anggota</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data milik <strong id="memberName" class="text-gray-800"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
                    <form id="deleteForm" action="" method="POST" class="m-0 w-full sm:w-auto">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-6 py-2.5 bg-rose-600 text-sm font-bold text-white shadow-sm hover:bg-rose-700 transition">
                            Ya, Hapus
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 px-6 py-2.5 bg-white text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL HAPUS MASSAL (BULK DELETE) --}}
    {{-- ================================================= --}}
    <div id="bulkDeleteModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-[1.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full border-t-4 border-rose-600">
                <div class="bg-white px-6 pt-6 pb-6">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2 flex items-center gap-2"><span>🧹</span> Hapus Massal Siswa Lulus</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Anda akan menghapus permanen <strong>{{ $graduatedCount ?? 0 }} akun siswa</strong> yang berstatus lulus/alumni. <br><br>
                        <span class="text-[11px] text-rose-600 font-bold bg-rose-50 px-2 py-1 rounded uppercase tracking-wider border border-rose-100">Penting</span><br>
                        <span class="mt-1 block">Siswa yang masih memiliki tanggungan peminjaman buku aktif akan dilewati dan tidak ikut terhapus.</span>
                    </p>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
                    <form action="{{ route('admin.superadmin.members.destroy.graduated') }}" method="POST" class="m-0 w-full sm:w-auto">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-6 py-2.5 bg-rose-600 text-sm font-bold text-white shadow-sm hover:bg-rose-700 transition">
                            Hapus Semua
                        </button>
                    </form>
                    <button type="button" onclick="closeBulkDeleteModal()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 px-6 py-2.5 bg-white text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition">
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
        const memberNameEl = document.getElementById('memberName');
        const bulkDeleteModal = document.getElementById('bulkDeleteModal');

        function openDeleteModal(url, name) {
            deleteForm.action = url;
            memberNameEl.textContent = name;
            deleteModal.classList.remove('hidden');
        }
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }
        function openBulkDeleteModal() {
            bulkDeleteModal.classList.remove('hidden');
        }
        function closeBulkDeleteModal() {
            bulkDeleteModal.classList.add('hidden');
        }

        // Tutup modal jika klik di luar kotak modal
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-slate-900/60')) {
                closeDeleteModal();
                closeBulkDeleteModal();
            }
        }
    </script>
@endsection
