@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
            Selamat Datang, Super {{ strtok(Auth::user()->name, " ") }}!
            {{-- Heroicon: Sparkles --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-amber-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09l2.846.813-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.428-1.428L13.5 18.75l1.178-.394a2.25 2.25 0 0 0 1.428-1.428l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.428 1.428l1.183.394-1.183.394a2.25 2.25 0 0 0-1.428 1.428Z" />
            </svg>
        </h2>
        <p class="text-gray-500 mt-1 font-medium">Ini adalah pusat kendali tingkat tinggi untuk mengelola ekosistem MyMulticompLibrary.</p>
    </div>

    {{-- KARTU STATISTIK UTAMA --}}
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

    {{-- BARIS TENGAH: GRAFIK PERTUMBUHAN & SMART DUE DATE --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Grafik Pertumbuhan Anggota (Line Chart) --}}
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    {{-- Heroicon: Chart Bar --}}
                    <div class="bg-blue-50 p-2 rounded-xl text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
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
                {{-- Heroicon: Clock --}}
                <div class="bg-rose-50 p-2 rounded-xl text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mb-2 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <p class="text-gray-500 text-xs font-medium">Sistem belum mengumpulkan cukup data riwayat kembali.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- BARIS BAWAH: LOG AUDIT & PANDUAN CEPAT --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Widget Log Audit Sistem --}}
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                {{-- Heroicon: Shield Check --}}
                <div class="bg-indigo-50 p-2 rounded-xl text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Audit Log Sistem</h3>
                    <p class="text-xs font-medium text-gray-500">Aktivitas penambahan master data terbaru</p>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4 max-h-[300px]">
                @forelse($auditLogs ?? [] as $log)
                    <div class="flex gap-4 items-start p-3 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                        {{-- Icon Berdasarkan Tipe (Membajak Emoji dari Controller menjadi SVG) --}}
                        <div class="w-10 h-10 rounded-full shrink-0 flex items-center justify-center shadow-sm
                            {{ $log->type == 'book' ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600' }}">

                            @if($log->type == 'book')
                                {{-- Heroicon: Book Open --}}
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                                </svg>
                            @else
                                {{-- Heroicon: User --}}
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                                </svg>
                            @endif
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
                {{-- Heroicon: Light Bulb --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-amber-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.829 1.508-2.316a7.5 7.5 0 1 0-7.516 0c.85.487 1.508 1.333 1.508 2.316V18" />
                </svg>
                Panduan Cepat
            </h3>

            <div class="space-y-6">
                <div class="flex gap-4 items-start">
                    <div class="bg-blue-50 w-12 h-12 flex items-center justify-center rounded-2xl shrink-0">
                        {{-- Heroicon: Identification (Manajemen Staf) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Manajemen Staf</h4>
                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">Tambah, edit, atau hapus akun untuk petugas perpustakaan.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <div class="bg-indigo-50 w-12 h-12 flex items-center justify-center rounded-2xl shrink-0">
                        {{-- Heroicon: User Group (Kelola Anggota) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-indigo-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Kelola Anggota</h4>
                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">Kelola semua data siswa & guru yang terdaftar dalam sistem.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <div class="bg-rose-50 w-12 h-12 flex items-center justify-center rounded-2xl shrink-0">
                        {{-- Heroicon: Cog (Sistem & Master) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-rose-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
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
