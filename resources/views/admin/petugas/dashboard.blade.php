@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Halo, {{ strtok(Auth::user()->name, " ") }}! 👋</h2>
        <p class="text-gray-500 mt-1 font-medium">Selamat bertugas. Berikut ringkasan aktivitas perpustakaan hari ini.</p>
    </div>

    {{-- KARTU STATISTIK PETUGAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="text-4xl font-extrabold text-emerald-500">{{ $pendingStudentsCount ?? '0' }}</div>
            <div class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wider">Menunggu Verifikasi</div>
        </div>
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="text-4xl font-extrabold text-gray-800">{{ $pengajuanPinjaman ?? '0' }}</div>
            <div class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wider">Pengajuan Pinjam</div>
        </div>
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="text-4xl font-extrabold text-gray-800">{{ $bukuDipinjam ?? '0' }}</div>
            <div class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wider">Buku Sedang Dipinjam</div>
        </div>
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="text-4xl font-extrabold text-red-500">{{ $terlambat ?? '0' }}</div>
            <div class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wider">Telat Kembali</div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- BARIS GRAFIK: GRAFIK GARIS (KIRI) & DONAT GENRE (KANAN) --}}
    {{-- ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- GRAFIK GARIS (STATISTIK PEMINJAMAN BULAN INI) --}}
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">📈</span>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Statistik Peminjaman</h3>
                    <p class="text-xs font-medium text-gray-500">Aktivitas harian selama bulan {{ $currentMonthName ?? 'Ini' }}</p>
                </div>
            </div>
            <div class="relative w-full h-72 flex-1">
                <canvas id="borrowingChart"></canvas>
            </div>
        </div>

        {{-- GRAFIK DONAT (GENRE TERLARIS) --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">🍩</span>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Genre Terlaris</h3>
                    <p class="text-xs font-medium text-gray-500">Top 5 Kategori Pilihan</p>
                </div>
            </div>
            @if(isset($genreData) && count($genreData) > 0)
                <div class="relative w-full h-64 flex-1 flex items-center justify-center">
                    <canvas id="genreChart"></canvas>
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-center p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <span class="text-2xl block mb-2 opacity-50">📊</span>
                    <p class="text-gray-500 text-xs font-medium">Belum ada data peminjaman untuk menampilkan genre terlaris.</p>
                </div>
            @endif
        </div>

    </div>

    {{-- ========================================================== --}}
    {{-- BARIS WIDGET: TOP READERS (KIRI) & NOTIFIKASI (KANAN) --}}
    {{-- ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- MONITOR GAMIFIKASI (JUARA MEMBACA) --}}
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🏆</span>
                    <div>
                        <h3 class="font-extrabold text-gray-900 text-lg">Peringkat Pembaca</h3>
                        <p class="text-xs font-medium text-gray-500">Top 3 Siswa Teraktif</p>
                    </div>
                </div>
            </div>

            @if(isset($topReaders) && $topReaders->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($topReaders as $index => $reader)
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 flex flex-col items-center text-center relative overflow-hidden transition hover:shadow-md hover:border-emerald-200">
                            {{-- Latar Belakang Medali --}}
                            <div class="absolute -right-4 -top-4 text-6xl opacity-10">
                                {{ $index === 0 ? '🥇' : ($index === 1 ? '🥈' : '🥉') }}
                            </div>

                            {{-- Foto Profil --}}
                            <div class="w-16 h-16 mb-3 rounded-full border-4 border-white shadow-sm overflow-hidden bg-white flex items-center justify-center text-xl font-bold text-gray-400 z-10">
                                @if($reader->profile_photo)
                                    <img src="{{ Storage::url($reader->profile_photo) }}" alt="Foto" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($reader->name, 0, 2)) }}
                                @endif
                            </div>

                            {{-- Info --}}
                            <h4 class="font-bold text-gray-900 text-sm w-full truncate z-10" title="{{ $reader->name }}">{{ $reader->name }}</h4>
                            <span class="text-xs font-medium text-gray-500 mt-0.5 z-10">{{ $reader->class ?? 'Siswa' }}</span>

                            <div class="mt-3 bg-white px-4 py-1.5 rounded-lg border border-gray-100 shadow-sm z-10">
                                <span class="font-extrabold text-emerald-600">{{ $reader->borrowings_count }}</span>
                                <span class="text-[10px] text-gray-400 font-bold ml-1 uppercase">Buku</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full flex flex-col items-center justify-center text-center p-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <span class="text-3xl block mb-2 opacity-50">😴</span>
                    <p class="text-gray-500 text-sm font-medium">Belum ada siswa yang meminjam buku saat ini.</p>
                </div>
            @endif
        </div>

        {{-- WIDGET AKTIVITAS TERBARU (NOTIFIKASI) --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">⚡</span>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Aktivitas Terbaru</h3>
                    <p class="text-xs font-medium text-gray-500">Log transaksi peminjaman</p>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4 max-h-[220px]">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="flex gap-3 items-start">
                        {{-- Ikon Status --}}
                        <div class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center text-xs mt-1
                            {{ $activity->status == 'pending' ? 'bg-amber-100 text-amber-600' :
                               ($activity->status == 'dipinjam' ? 'bg-blue-100 text-blue-600' :
                               ($activity->status == 'dikembalikan' || $activity->status == 'returned' ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-600')) }}">
                            @if($activity->status == 'pending') ⏳
                            @elseif($activity->status == 'dipinjam') 📖
                            @elseif($activity->status == 'dikembalikan' || $activity->status == 'returned') ✅
                            @else 📌 @endif
                        </div>

                        {{-- Konten Log --}}
                        <div>
                            <p class="text-xs text-gray-800 leading-relaxed">
                                <span class="font-bold text-gray-900">{{ strtok($activity->user->name, " ") }}</span>
                                @if($activity->status == 'pending') mengajukan pinjaman
                                @elseif($activity->status == 'dipinjam') sedang meminjam
                                @elseif($activity->status == 'dikembalikan' || $activity->status == 'returned') mengembalikan
                                @else mengubah status @endif
                                <span class="font-bold text-indigo-600">{{ Str::limit($activity->bookCopy->book->title, 25) }}</span>
                            </p>
                            <p class="text-[10px] text-gray-400 mt-1 font-medium">
                                {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-4">
                        <p class="text-gray-400 text-xs font-medium">Belum ada aktivitas terekam.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ========================================================== --}}
    {{-- PANDUAN KERJA PUSTAKAWAN --}}
    {{-- ========================================================== --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm p-8 border border-gray-100">
        <h3 class="text-xl font-extrabold text-gray-900 mb-6">Alur Kerja Pustakawan</h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="space-y-3">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-4">👥</div>
                <h4 class="font-bold text-gray-900">1. Anggota</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Cek menu Verifikasi Siswa setiap pagi untuk menyetujui pendaftaran anggota baru.</p>
            </div>
            <div class="space-y-3">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-4">🔄</div>
                <h4 class="font-bold text-gray-900">2. Sirkulasi Buku</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Proses pengajuan pinjaman masuk, tangani pengembalian, dan catat denda keterlambatan.</p>
            </div>
            <div class="space-y-3">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-4">🗃️</div>
                <h4 class="font-bold text-gray-900">3. Data Pustaka</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Pastikan katalog buku selalu *up-to-date* jika ada penambahan stok buku baru.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Import Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. INIT GRAFIK GARIS (PEMINJAMAN)
            const lineCtx = document.getElementById('borrowingChart');
            if (lineCtx) {
                const labels = {!! json_encode($chartLabels ?? []) !!};
                const dataPoints = {!! json_encode($chartData ?? []) !!};

                new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pinjaman',
                            data: dataPoints,
                            borderColor: '#059669', // Emerald 600
                            backgroundColor: 'rgba(5, 150, 105, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#059669',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleFont: { size: 13 },
                                bodyFont: { size: 14, weight: 'bold' },
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    title: function(tooltipItems) { return 'Tanggal ' + tooltipItems[0].label; }
                                }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1, color: '#94a3b8' }, grid: { color: '#f1f5f9', drawBorder: false } },
                            x: { ticks: { color: '#94a3b8' }, grid: { display: false, drawBorder: false } }
                        }
                    }
                });
            }

            // 2. INIT GRAFIK DONAT (GENRE BUKU)
            const donutCtx = document.getElementById('genreChart');
            if (donutCtx) {
                const genreLabels = {!! json_encode($genreLabels ?? []) !!};
                const genreData = {!! json_encode($genreData ?? []) !!};

                // Array warna-warna pastel Tailwind yang cantik
                const bgColors = ['#059669', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6'];
                const hoverColors = ['#047857', '#2563eb', '#d97706', '#dc2626', '#7c3aed'];

                new Chart(donutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: genreLabels,
                        datasets: [{
                            data: genreData,
                            backgroundColor: bgColors,
                            hoverBackgroundColor: hoverColors,
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%', // Ketebalan donat
                        plugins: {
                            legend: {
                                position: 'right', // Legenda di sebelah kanan
                                labels: {
                                    usePointStyle: true,
                                    padding: 15,
                                    font: { family: "'Inter', sans-serif", size: 11, weight: '600' },
                                    color: '#475569'
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                bodyFont: { size: 13, weight: 'bold' },
                                callbacks: {
                                    label: function(context) {
                                        return ' ' + context.parsed + ' Peminjaman';
                                    }
                                }
                            }
                        }
                    }
                });
            }

        });
    </script>

    <style>
        /* Mempercantik Scrollbar di Widget Notifikasi */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #cbd5e1; }
    </style>
@endpush
