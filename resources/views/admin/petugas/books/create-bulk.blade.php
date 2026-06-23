@extends('layouts.admin')

@section('content')
    <div class="max-w-[100rem] mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Banyak Buku</h2>
                <p class="text-gray-500 mt-1 font-medium">Masukkan informasi beberapa buku sekaligus dalam satu kali proses.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.petugas.books.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali ke Katalog
                </a>
            </div>
        </div>

        {{-- Notifikasi Error General --}}
        @if ($errors->has('general'))
            <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
                <span class="text-xl">⚠️</span> {{ $errors->first('general') }}
            </div>
        @endif

        {{-- Notifikasi Error Array (Per Baris) --}}
        @if ($errors->has('books.*'))
            <div class="mb-6 p-5 bg-amber-50 border border-amber-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold text-amber-800">
                    <span class="text-xl">⚠️</span> Periksa Kembali Input Anda:
                </div>
                <ul class="list-disc list-inside text-sm font-medium text-amber-700 pl-2 space-y-1">
                    @foreach ($errors->get('books.*') as $fieldErrors)
                        @foreach ($fieldErrors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endforeach
                    @foreach (array_keys($errors->messages()) as $key)
                        @if (preg_match('/^books\.\d+\.initial_code$/', $key))
                            <li>{{ $errors->first($key) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Utama --}}
        <form action="{{ route('admin.petugas.books.store.bulk.form') }}" method="POST" id="bulk-book-form">
            @csrf

            <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col">

                {{-- Header Tabel & Tombol Tambah Baris --}}
                <div class="p-5 border-b border-gray-100 bg-slate-900 flex justify-between items-center">
                    <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                        <span>📝</span> Formulir Input Massal
                    </h3>
                    <button type="button" id="add-book-row" class="inline-flex items-center gap-2 bg-emerald-500 text-white font-bold py-2 px-4 rounded-xl hover:bg-emerald-400 transition shadow-sm text-sm">
                        <span>➕</span> Tambah Baris
                    </button>
                </div>

                {{-- Container Tabel (Scrollable Horizontal) --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1200px]">
                        <thead class="bg-gray-50/80 border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider min-w-[200px]">Judul <span class="text-rose-500">*</span></th>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider min-w-[150px]">Penulis <span class="text-rose-500">*</span></th>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider min-w-[150px]">Genre <span class="text-rose-500">*</span></th>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider min-w-[150px]">Rak <span class="text-rose-500">*</span></th>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider min-w-[120px]">Kode <span class="text-rose-500">*</span></th>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider w-24">Stok <span class="text-rose-500">*</span></th>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider w-24">Tahun</th>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider min-w-[180px]">Sinopsis</th>
                                <th class="px-4 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider min-w-[140px]">Tipe <span class="text-rose-500">*</span></th>
                                <th class="px-4 py-4 text-right w-16"></th>
                            </tr>
                        </thead>
                        <tbody id="book-rows-container" class="divide-y divide-gray-100">
                            @php
                                $rowCount = max(1, count(old('books', [[]])));
                            @endphp

                            @for ($i = 0; $i < $rowCount; $i++)
                                <tr class="book-row hover:bg-gray-50/50 transition">
                                    {{-- Judul --}}
                                    <td class="px-3 py-3">
                                        <input type="text" name="books[{{ $i }}][title]" value="{{ old('books.'.$i.'.title') }}" required placeholder="Judul Buku"
                                               class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.title') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white">
                                    </td>

                                    {{-- Penulis --}}
                                    <td class="px-3 py-3">
                                        <input type="text" name="books[{{ $i }}][author]" value="{{ old('books.'.$i.'.author') }}" required placeholder="Penulis"
                                               class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.author') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white">
                                    </td>

                                    {{-- Genre --}}
                                    <td class="px-3 py-3">
                                        <select name="books[{{ $i }}][genre_id]" required class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.genre_id') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white cursor-pointer">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($genres as $genre)
                                                <option value="{{ $genre->id }}" {{ old('books.'.$i.'.genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    {{-- Rak --}}
                                    <td class="px-3 py-3">
                                        <select name="books[{{ $i }}][shelf_id]" required class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.shelf_id') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white cursor-pointer">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($shelves as $shelf)
                                                <option value="{{ $shelf->id }}" {{ old('books.'.$i.'.shelf_id') == $shelf->id ? 'selected' : '' }}>{{ $shelf->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    {{-- Kode Awal --}}
                                    <td class="px-3 py-3">
                                        <input type="text" name="books[{{ $i }}][initial_code]" value="{{ old('books.'.$i.'.initial_code') }}" required maxlength="10" placeholder="Cont: IPA"
                                               class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.initial_code') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white uppercase font-bold text-center">
                                    </td>

                                    {{-- Stok --}}
                                    <td class="px-3 py-3">
                                        <input type="number" name="books[{{ $i }}][stock]" value="{{ old('books.'.$i.'.stock', 1) }}" required min="1" max="100" placeholder="1"
                                               class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.stock') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white text-center font-bold">
                                    </td>

                                    {{-- Tahun Terbit --}}
                                    <td class="px-3 py-3">
                                        <input type="number" name="books[{{ $i }}][publication_year]" value="{{ old('books.'.$i.'.publication_year') }}" min="1900" max="{{ date('Y') }}" placeholder="{{ date('Y') }}"
                                               class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.publication_year') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white text-center">
                                    </td>

                                    {{-- Sinopsis --}}
                                    <td class="px-3 py-3">
                                        <textarea name="books[{{ $i }}][synopsis]" rows="1" placeholder="Opsional"
                                                  class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.synopsis') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white resize-none">{{ old('books.'.$i.'.synopsis') }}</textarea>
                                    </td>

                                    {{-- Tipe Buku --}}
                                    <td class="px-3 py-3">
                                        <select name="books[{{ $i }}][book_type]" required class="w-full px-3 py-2 rounded-lg border @error('books.'.$i.'.book_type') border-rose-500 @else border-gray-200 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition text-sm bg-white cursor-pointer">
                                            <option value="reguler" {{ old('books.'.$i.'.book_type') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                            <option value="paket" {{ old('books.'.$i.'.book_type') == 'paket' ? 'selected' : '' }}>Buku Paket</option>
                                            <option value="laporan" {{ old('books.'.$i.'.book_type') == 'laporan' ? 'selected' : '' }}>Laporan</option>
                                        </select>
                                    </td>

                                    {{-- Aksi (Hapus Baris) --}}
                                    <td class="px-4 py-3 text-right">
                                        @if($i > 0 || $rowCount > 1)
                                            <button type="button" class="remove-book-row w-8 h-8 inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 rounded-lg transition border border-rose-100" title="Hapus Baris">
                                                🗑️
                                            </button>
                                        @else
                                            <button type="button" class="remove-book-row w-8 h-8 inline-flex items-center justify-center bg-gray-50 text-gray-400 rounded-lg transition border border-transparent opacity-50 cursor-not-allowed invisible" disabled title="Tidak bisa dihapus">
                                                🗑️
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                {{-- Footer Action --}}
                <div class="p-6 bg-slate-50 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs font-medium text-gray-500 hidden sm:block">Periksa kembali data sebelum menyimpan.</p>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-emerald-700 transition shadow-sm text-sm">
                            💾 Simpan Semua Buku
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('book-rows-container');
            const addButton = document.getElementById('add-book-row');
            const bulkForm = document.getElementById('bulk-book-form');
            let rowIndex = container.querySelectorAll('.book-row').length;

            // Update status tombol hapus
            function updateRemoveButtons() {
                const rows = container.querySelectorAll('.book-row');
                rows.forEach((row, index) => {
                    let removeButton = row.querySelector('.remove-book-row');
                    const actionCell = row.cells[row.cells.length - 1];

                    if (rows.length <= 1) {
                        if (!removeButton) {
                            actionCell.innerHTML = `<button type="button" class="remove-book-row w-8 h-8 inline-flex items-center justify-center bg-gray-50 text-gray-400 rounded-lg transition border border-transparent opacity-50 cursor-not-allowed invisible" disabled>🗑️</button>`;
                        } else {
                            removeButton.classList.add('invisible', 'bg-gray-50', 'text-gray-400', 'border-transparent', 'opacity-50', 'cursor-not-allowed');
                            removeButton.classList.remove('bg-rose-50', 'text-rose-600', 'hover:bg-rose-100', 'hover:text-rose-700', 'border-rose-100');
                            removeButton.disabled = true;
                        }
                    } else {
                        if (!removeButton || removeButton.classList.contains('invisible')) {
                            actionCell.innerHTML = `<button type="button" class="remove-book-row w-8 h-8 inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 rounded-lg transition border border-rose-100" title="Hapus Baris">🗑️</button>`;
                        } else {
                            removeButton.classList.remove('invisible', 'bg-gray-50', 'text-gray-400', 'border-transparent', 'opacity-50', 'cursor-not-allowed');
                            removeButton.classList.add('bg-rose-50', 'text-rose-600', 'hover:bg-rose-100', 'hover:text-rose-700', 'border-rose-100');
                            removeButton.disabled = false;
                        }
                    }
                });
            }

            // Tambah Baris Baru
            addButton.addEventListener('click', function () {
                const lastRow = container.querySelector('.book-row:last-child');
                if (!lastRow) return;

                const newRow = lastRow.cloneNode(true);

                newRow.querySelectorAll('input, select, textarea').forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIndex}]`));
                    }
                    const id = input.getAttribute('id');
                    if (id) {
                        const newId = id.replace(/_\d+$/, `_${rowIndex}`);
                        input.setAttribute('id', newId);
                    }

                    // Reset Nilai & Class Error
                    if (input.tagName === 'SELECT') {
                        if (input.name && input.name.includes('[book_type]')) {
                            input.value = 'reguler';
                        } else {
                            input.selectedIndex = 0;
                        }
                    } else if (input.name && input.name.includes('[stock]')) {
                        input.value = '1';
                    } else {
                        input.value = '';
                    }
                    input.classList.remove('border-rose-500');
                    input.classList.add('border-gray-200');
                });

                const actionCell = newRow.cells[newRow.cells.length - 1];
                actionCell.innerHTML = `<button type="button" class="remove-book-row w-8 h-8 inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 rounded-lg transition border border-rose-100" title="Hapus Baris">🗑️</button>`;

                container.appendChild(newRow);
                rowIndex++;
                updateRemoveButtons();
            });

            // Hapus Baris
            container.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.remove-book-row');
                if (removeButton) {
                    const rowToRemove = removeButton.closest('.book-row');
                    if (container.querySelectorAll('.book-row').length > 1) {
                        rowToRemove.remove();
                        updateRemoveButtons();
                    }
                }
            });

            // SweetAlert Konfirmasi Submit
            if(bulkForm) {
                bulkForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const totalRows = container.querySelectorAll('.book-row').length;

                    Swal.fire({
                        title: 'Simpan Massal?',
                        html: `Sistem akan memproses dan menyimpan <strong>${totalRows} data buku baru</strong> beserta seluruh eksemplarnya.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#059669',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Simpan Semua',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            bulkForm.submit();
                        }
                    });
                });
            }

            updateRemoveButtons();
        });
    </script>
@endpush
