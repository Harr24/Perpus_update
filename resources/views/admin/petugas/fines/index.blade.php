@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Denda</h2>
                <p class="text-gray-500 mt-1 font-medium">Daftar denda keterlambatan yang belum lunas atau sedang dicicil.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali
                </a>
                <a href="{{ route('admin.petugas.fines.history') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-slate-800 transition shadow-sm text-sm border border-transparent">
                    <span>🕰️</span> Riwayat Lunas
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

        @if ($errors->any())
            <div class="mb-6 p-5 bg-rose-50 border border-rose-100 rounded-xl shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold text-rose-700">
                    <span class="text-xl">⚠️</span> Terjadi Kesalahan!
                </div>
                <ul class="list-disc list-inside text-sm font-medium text-rose-600 pl-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Kontainer Utama --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-6 border-b border-gray-100 bg-rose-50/50 flex items-center gap-3">
                <span class="text-rose-500 text-xl">💸</span>
                <h3 class="text-lg font-extrabold text-rose-900">Denda Belum Lunas</h3>
            </div>

            {{-- Tabel Data --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Detail Denda</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Telat</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($unpaidFines as $fine)
                            @php
                                $sisaDenda = $fine->fine_amount - ($fine->fine_paid ?? 0);
                            @endphp
                            <tr class="hover:bg-gray-50/80 transition duration-200">

                                {{-- Peminjam & Kelas --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900">{{ $fine->user->name ?? 'User Terhapus' }}</span>
                                        <div class="mt-1">
                                            @if ($fine->user)
                                                @if ($fine->user->role == 'siswa')
                                                    @if ($fine->user->class == 'Lulus')
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">ALUMNI</span>
                                                    @elseif (!empty($fine->user->class) && !empty($fine->user->major))
                                                        <span class="text-xs text-gray-600 font-medium">{{ $fine->user->class }} - {{ $fine->user->major }}</span>
                                                    @elseif (!empty($fine->user->class) || !empty($fine->user->major))
                                                        <span class="text-xs text-gray-600 font-medium">{{ $fine->user->class }} {{ $fine->user->major }}</span>
                                                    @elseif (!empty($fine->user->class_name))
                                                        <span class="text-xs text-gray-600 font-medium">{{ $fine->user->class_name }}</span>
                                                    @else
                                                        <span class="text-xs text-gray-400 italic">-</span>
                                                    @endif
                                                @elseif ($fine->user->role == 'guru')
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">GURU</span>
                                                @endif
                                            @else
                                                <span class="text-xs text-rose-500 italic">User Hilang</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Kontak WA --}}
                                <td class="px-6 py-4">
                                    @if($fine->user && $fine->user->phone_number)
                                        @php
                                            $cleanedPhone = preg_replace('/[^0-9]/', '', $fine->user->phone_number);
                                            $waNumber = (substr($cleanedPhone, 0, 1) === '0') ? '62' . substr($cleanedPhone, 1) : $cleanedPhone;
                                        @endphp
                                        <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition border border-emerald-200">
                                            <span>💬</span> Chat WA
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">-</span>
                                    @endif
                                </td>

                                {{-- Buku --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $fine->bookCopy->book->title ?? 'Buku Terhapus' }}</div>
                                    <div class="text-[10px] font-mono text-gray-500 mt-0.5 tracking-wider bg-gray-100 inline-block px-2 py-0.5 rounded border border-gray-200">
                                        {{ $fine->bookCopy->book_code ?? '-' }}
                                    </div>
                                </td>

                                {{-- Detail Denda --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-1 w-40 text-xs">
                                        <div class="flex justify-between items-center text-gray-500 font-medium">
                                            <span>Total:</span>
                                            <span>Rp {{ number_format($fine->fine_amount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-emerald-600 font-bold border-b border-dashed border-gray-200 pb-1">
                                            <span>Dibayar:</span>
                                            <span>Rp {{ number_format($fine->fine_paid ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-rose-600 font-extrabold pt-0.5 text-sm">
                                            <span>Sisa:</span>
                                            <span>Rp {{ number_format($sisaDenda, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Hari Telat --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1.5 rounded-lg text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                        {{ $fine->late_days }} Hari
                                    </span>
                                </td>

                                {{-- Aksi Pembayaran --}}
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.petugas.fines.pay', $fine) }}" method="POST" class="form-pay-fine inline-flex items-center gap-2 m-0 justify-end">
                                        @csrf

                                        <div class="relative w-28">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-gray-500 font-bold text-xs pointer-events-none">Rp</span>
                                            <input type="number" name="amount" required min="1" max="{{ $sisaDenda }}" value="{{ $sisaDenda }}"
                                                   title="Ubah nominal untuk mencicil"
                                                   class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-xs font-bold text-gray-700 transition bg-gray-50 focus:bg-white text-right">
                                        </div>

                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-lg text-xs font-bold shadow-sm transition flex items-center gap-1">
                                            Bayar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-5xl mb-4 opacity-50">✨</span>
                                        <h3 class="text-lg font-bold text-gray-900">Bersih!</h3>
                                        <p class="text-gray-500 mt-1">Tidak ada denda yang belum lunas saat ini.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Konfirmasi Pembayaran
            document.querySelectorAll('.form-pay-fine').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Ambil nilai yang diketik di input
                    const inputAmount = form.querySelector('input[name="amount"]').value;
                    const maxAmount = form.querySelector('input[name="amount"]').max;

                    // Format angka ke rupiah
                    const formattedInput = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(inputAmount);

                    let titleText = 'Proses Pembayaran?';
                    let descText = `Anda akan memproses pembayaran sebesar <strong style="color:#059669">${formattedInput}</strong>.`;

                    // Jika bayar kurang dari sisa (Cicilan)
                    if (parseInt(inputAmount) < parseInt(maxAmount)) {
                        titleText = 'Proses Cicilan Denda?';
                        descText += '<br><br><span style="font-size: 0.9em; color:#d97706;">Sisa denda masih akan tercatat di sistem.</span>';
                    }

                    Swal.fire({
                        title: titleText,
                        html: descText,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#059669', // Emerald
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Bayar',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

        });
    </script>
@endpush
