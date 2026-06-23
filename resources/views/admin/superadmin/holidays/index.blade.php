@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Tanggal Merah</h2>
                <p class="text-gray-500 mt-1 font-medium">Kelola daftar hari libur nasional dan cuti bersama dalam sistem.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3">
                <span class="text-xl">✅</span> {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error Validasi --}}
        @if($errors->any())
            <div class="mb-6 p-5 bg-rose-50 border border-rose-100 rounded-xl">
                <div class="flex items-center gap-2 mb-2 font-bold text-rose-700">
                    <span class="text-xl">⚠️</span> Gagal Memproses!
                </div>
                <p class="text-sm font-medium text-rose-600 mb-2">Terdapat kesalahan pada data yang Anda masukkan:</p>
                <ul class="list-disc list-inside text-sm font-medium text-rose-600 pl-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ========================================== --}}
            {{-- KOLOM KIRI: FORM TAMBAH TANGGAL MERAH --}}
            {{-- ========================================== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                    <div class="p-6 border-b border-gray-100 bg-slate-900">
                        <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                            <span>📅</span> Tambah Libur
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.superadmin.holidays.store') }}" method="POST">
                            @csrf

                            {{-- Input Tanggal --}}
                            <div class="mb-5">
                                <label for="holiday_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Libur <span class="text-rose-500">*</span></label>
                                <input type="date" id="holiday_date" name="holiday_date" value="{{ old('holiday_date') }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-gray-50 focus:bg-white text-gray-700 font-medium">
                            </div>

                            {{-- Input Keterangan --}}
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Keterangan <span class="text-rose-500">*</span></label>
                                <input type="text" id="description" name="description" value="{{ old('description') }}" required
                                       placeholder="Contoh: Hari Kemerdekaan RI"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            </div>

                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-slate-900 text-white font-bold py-3 px-4 rounded-xl hover:bg-slate-800 transition shadow-sm">
                                Simpan Tanggal
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- KOLOM KANAN: DAFTAR TANGGAL MERAH --}}
            {{-- ========================================== --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">

                    {{-- Header & Filter --}}
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                            <span>📌</span> Daftar Tanggal Merah
                        </h3>

                        <form action="{{ route('admin.superadmin.holidays.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                            <select name="year" class="w-full sm:w-40 px-4 py-2.5 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-white text-sm font-bold text-gray-700 cursor-pointer shadow-sm">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                        Tahun {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                                Filter
                            </button>
                        </form>
                    </div>

                    {{-- Tabel --}}
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-white border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($holidays as $holiday)
                                    <tr class="hover:bg-gray-50/50 transition duration-200">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900 text-sm mb-0.5">{{ $holiday->holiday_date->format('d M Y') }}</div>
                                            <div class="text-xs text-rose-500 font-semibold">{{ $holiday->holiday_date->translatedFormat('l') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-700">
                                            {{ $holiday->description }}
                                        </td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-2">
                                                {{-- Tombol Edit (Buka Modal) --}}
                                                <button type="button" onclick="openEditModal({{ $holiday->id }})" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-sm font-bold transition">
                                                    Edit
                                                </button>
                                                {{-- Tombol Hapus (Buka Modal Konfirmasi) --}}
                                                <button type="button" onclick="openDeleteModal('{{ route('admin.superadmin.holidays.destroy', $holiday) }}', '{{ addslashes($holiday->description) }}')" class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg text-sm font-bold transition">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <span class="text-4xl mb-3">🗓️</span>
                                                <h3 class="text-base font-bold text-gray-900">Tidak ada tanggal merah</h3>
                                                <p class="text-sm text-gray-500 mt-1">Belum ada data libur untuk tahun {{ $selectedYear }}.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL HAPUS TANGGAL MERAH --}}
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
                            <h3 class="text-lg leading-6 font-extrabold text-gray-900">Hapus Tanggal Merah</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data libur <strong id="holidayDesc" class="text-gray-800"></strong>?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                    <form id="deleteForm" action="" method="POST" class="m-0">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl px-4 py-2 bg-rose-600 text-base font-bold text-white shadow-sm hover:bg-rose-700 sm:w-auto sm:text-sm transition">
                            Ya, Hapus
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-gray-300 px-4 py-2 bg-white text-base font-bold text-gray-700 shadow-sm hover:bg-gray-50 sm:w-auto sm:text-sm transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL EDIT TANGGAL MERAH (AJAX FETCH) --}}
    {{-- ================================================= --}}
    <div id="editHolidayModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full border border-gray-100">

                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-extrabold text-gray-900">Edit Tanggal Merah</h3>
                    <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form id="editHolidayForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-6">
                        <div class="mb-5">
                            <label for="edit_holiday_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Libur <span class="text-rose-500">*</span></label>
                            <input type="date" id="edit_holiday_date" name="edit_holiday_date" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-gray-50 focus:bg-white text-gray-700 font-medium">
                        </div>
                        <div class="mb-2">
                            <label for="edit_description" class="block text-sm font-bold text-gray-700 mb-2">Keterangan <span class="text-rose-500">*</span></label>
                            <input type="text" id="edit_description" name="edit_description" required
                                   placeholder="Contoh: Hari Raya Idul Fitri"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" id="btnUpdate" class="w-full inline-flex justify-center rounded-xl px-4 py-2 bg-slate-900 text-base font-bold text-white shadow-sm hover:bg-slate-800 sm:w-auto sm:text-sm transition">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeEditModal()" class="w-full inline-flex justify-center rounded-xl border border-gray-300 px-4 py-2 bg-white text-base font-bold text-gray-700 shadow-sm hover:bg-gray-50 sm:w-auto sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script JavaScript Murni (Vanilla JS) --}}
    <script>
        // DOM Elements Delete Modal
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const holidayDescEl = document.getElementById('holidayDesc');

        // DOM Elements Edit Modal
        const editModal = document.getElementById('editHolidayModal');
        const editForm = document.getElementById('editHolidayForm');
        const editDateInput = document.getElementById('edit_holiday_date');
        const editDescInput = document.getElementById('edit_description');
        const btnUpdate = document.getElementById('btnUpdate');

        // Functions Delete Modal
        function openDeleteModal(url, desc) {
            deleteForm.action = url;
            holidayDescEl.textContent = desc;
            deleteModal.classList.remove('hidden');
        }
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        // Functions Edit Modal
        function openEditModal(holidayId) {
            // Ubah tombol jadi loading state
            btnUpdate.innerHTML = 'Memuat...';
            btnUpdate.disabled = true;

            // Set Form Action URL
            editForm.action = "{{ url('admin/superadmin/holidays') }}/" + holidayId;

            // Buka Modal
            editModal.classList.remove('hidden');

            // Fetch Data dari Server
            fetch("{{ url('admin/superadmin/holidays') }}/" + holidayId + "/edit")
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data');
                    return response.json();
                })
                .then(data => {
                    // Isi form dengan data yang didapat
                    editDateInput.value = data.holiday_date;
                    editDescInput.value = data.description;

                    // Kembalikan tombol
                    btnUpdate.innerHTML = 'Simpan Perubahan';
                    btnUpdate.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Tidak dapat memuat data. Silakan coba lagi.');
                    closeEditModal();
                });
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
            editForm.reset();
            editForm.action = '';
        }

        // Tutup modal jika klik background gelap
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-slate-900/60')) {
                closeDeleteModal();
                closeEditModal();
            }
        }
    </script>
@endsection
