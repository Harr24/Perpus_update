@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang, Super {{ strtok(Auth::user()->name, " ") }}! 🚀</h2>
        <p class="text-gray-500 mt-1 font-medium">Ini adalah pusat kendali tingkat tinggi untuk mengelola ekosistem MyMulticompLibrary.</p>
    </div>

    {{-- ========================================================== --}}
    {{-- KARTU STATISTIK UTAMA --}}
    {{-- ========================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="text-4xl font-extrabold text-blue-600">{{ $totalBuku ?? '0' }}</div>
            <div class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wider">Total Buku</div>
        </div>
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="text-4xl font-extrabold text-blue-600">{{ $anggotaAktif ?? '0' }}</div>
            <div class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wider">Anggota Aktif</div>
        </div>
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="text-4xl font-extrabold text-emerald-500">{{ $pengajuanPinjaman ?? '0' }}</div>
            <div class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wider">Pengajuan Baru</div>
        </div>
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="text-4xl font-extrabold text-rose-500">{{ $terlambat ?? '0' }}</div>
            <div class="text-sm text-gray-400 mt-2 font-bold uppercase tracking-wider">Terlambat</div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- BARIS TENGAH: GRAFIK PERTUMBUHAN & SMART DUE DATE --}}
    {{-- ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Grafik Pertumbuhan Anggota (Line Chart) --}}
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📈</span>
                    <div>
                        <h3 class="font-extrabold text-gray-900 text-lg">Tren Pertumbuhan Anggota</h3>
                        <p class="text-xs font-medium text-gray-500">Pendaftaran siswa dan guru di tahun {{ $currentYear ?? date('Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="relative w-full h-72 flex-1">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        {{-- Grafik Smart Due Date (Doughnut Chart) --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">🎯</span>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Smart Due Date</h3>
                    <p class="text-xs font-medium text-gray-500">Rasio Ketepatan Waktu Kembali</p>
                </div>
            </div>

            @php
                $hasData = isset($smartDueDateData) && array_sum($smartDueDateData) > 0;
            @endphp

            @if($hasData)
                <div class="relative w-full h-64 flex-1 flex items-center justify-center">
                    <canvas id="smartDueDateChart"></canvas>
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-center p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <span class="text-2xl block mb-2 opacity-50">📊</span>
                    <p class="text-gray-500 text-xs font-medium">Sistem belum mengumpulkan cukup data riwayat kembali.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- BARIS BAWAH: LOG AUDIT & PANDUAN CEPAT --}}
    {{-- ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Widget Log Audit Sistem --}}
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">🛡️</span>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Audit Log Sistem</h3>
                    <p class="text-xs font-medium text-gray-500">Aktivitas penambahan master data terbaru</p>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4 max-h-[300px]">
                @forelse($auditLogs ?? [] as $log)
                    <div class="flex gap-4 items-start p-3 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                        {{-- Icon Berdasarkan Tipe --}}
                        <div class="w-10 h-10 rounded-full shrink-0 flex items-center justify-center text-lg shadow-sm
                            {{ $log->type == 'book' ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600' }}">
                            {{ $log->icon }}
                        </div>

                        <div class="flex-1">
                            <p class="text-sm text-gray-800 font-bold leading-relaxed">
                                {{ $log->message }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1 font-medium flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($log->time)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <p class="text-gray-400 text-sm font-medium">Belum ada jejak audit sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Panduan Cepat Superadmin --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100">
            <h3 class="text-xl font-extrabold text-gray-900 mb-6 border-b border-gray-100 pb-4 flex items-center gap-2">
                <span>💡</span> Panduan Cepat
            </h3>

            <div class="space-y-6">
                <div class="flex gap-4 items-start">
                    <div class="bg-blue-50 w-12 h-12 flex items-center justify-center rounded-2xl text-2xl shrink-0">👨‍💼</div>
                    <div>
                        <h4 class="font-bold text-gray-900">Manajemen Staf</h4>
                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">Tambah, edit, atau hapus akun untuk petugas perpustakaan.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <div class="bg-indigo-50 w-12 h-12 flex items-center justify-center rounded-2xl text-2xl shrink-0">👥</div>
                    <div>
                        <h4 class="font-bold text-gray-900">Kelola Anggota</h4>
                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">Kelola semua data siswa & guru yang terdaftar dalam sistem.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <div class="bg-rose-50 w-12 h-12 flex items-center justify-center rounded-2xl text-2xl shrink-0">⚙️</div>
                    <div>
                        <h4 class="font-bold text-gray-900">Sistem & Master</h4>
                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">Atur tanggal merah, jadwal piket, serta rak buku untuk operasional.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Import Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. INIT GRAFIK PERTUMBUHAN ANGGOTA (LINE CHART)
            const growthCtx = document.getElementById('growthChart');
            if (growthCtx) {
                const labels = {!! json_encode($monthLabels ?? []) !!};
                const dataPoints = {!! json_encode($growthData ?? []) !!};

                new Chart(growthCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Anggota Baru',
                            data: dataPoints,
                            borderColor: '#3b82f6', // Biru
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#3b82f6',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4 // Melengkung mulus
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
                                displayColors: false
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1, color: '#94a3b8' }, grid: { color: '#f1f5f9', drawBorder: false } },
                            x: { ticks: { color: '#94a3b8' }, grid: { display: false, drawBorder: false } }
                        }
                    }
                });
            }

            // 2. INIT GRAFIK SMART DUE DATE (DOUGHNUT CHART)
            const dueCtx = document.getElementById('smartDueDateChart');
            if (dueCtx) {
                const dueData = {!! json_encode($smartDueDateData ?? [0, 0]) !!};

                new Chart(dueCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Tepat Waktu', 'Terlambat'],
                        datasets: [{
                            data: dueData,
                            backgroundColor: ['#10b981', '#f43f5e'], // Emerald (Hijau) & Rose (Merah)
                            hoverBackgroundColor: ['#059669', '#e11d48'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%', // Donat tipis elegan
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: { family: "'Inter', sans-serif", size: 12, weight: 'bold' },
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
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #cbd5e1; }
    </style>
@endpush
