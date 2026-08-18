@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
            Halo, {{ strtok(Auth::user()->name, " ") }}!
            {{-- Heroicon: Hand Raised --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-amber-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.575a1.575 1.575 0 1 0-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 0 1 3.15 0v1.5m-3.15 0 .075 5.925m3.075.75V4.875a1.575 1.575 0 0 1 3.15 0v2.625m-3.15 0V8.25m3.075 1.5V6.125a1.575 1.575 0 0 1 3.15 0v4.5m-3.15 0V11.25m3.075 2.25v-1.5a1.575 1.575 0 0 1 3.15 0v1.5m-3.15 0v.75a8.966 8.966 0 0 1-3 6.708 8.959 8.959 0 0 1-5.917 2.242 8.96 8.96 0 0 1-5.917-2.242 8.966 8.966 0 0 1-3-6.708v-1.5a1.575 1.575 0 0 1 3.15 0v1.5m11.85 0h-3" />
            </svg>
        </h2>
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
                {{-- Heroicon: Chart Bar --}}
                <div class="bg-emerald-50 p-2 rounded-xl text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
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
                {{-- Heroicon: Chart Pie --}}
                <div class="bg-blue-50 p-2 rounded-xl text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                </div>
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mb-2 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
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
                    {{-- Heroicon: Trophy --}}
                    <div class="bg-amber-50 p-2 rounded-xl text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </div>
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

                            {{-- Latar Belakang Tipografi Angka Klasemen (Menggantikan Emoji Medali) --}}
                            <div class="absolute -right-4 -top-4 text-8xl font-black opacity-[0.06] {{ $index === 0 ? 'text-amber-500' : ($index === 1 ? 'text-slate-500' : 'text-orange-500') }}">
                                {{ $index + 1 }}
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

                            <div class="mt-3 bg-white px-4 py-1.5 rounded-lg border border-gray-100 shadow-sm z-10 flex items-center gap-1">
                                <span class="font-extrabold text-emerald-600">{{ $reader->borrowings_count }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase">Buku</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full flex flex-col items-center justify-center text-center p-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mb-2 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                    </svg>
                    <p class="text-gray-500 text-sm font-medium">Belum ada siswa yang meminjam buku saat ini.</p>
                </div>
            @endif
        </div>

        {{-- WIDGET AKTIVITAS TERBARU (NOTIFIKASI) --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                {{-- Heroicon: Bolt --}}
                <div class="bg-indigo-50 p-2 rounded-xl text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Aktivitas Terbaru</h3>
                    <p class="text-xs font-medium text-gray-500">Log transaksi peminjaman</p>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4 max-h-[220px]">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="flex gap-3 items-start">
                        {{-- Ikon Status menggunakan SVG --}}
                        <div class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center text-xs mt-1
                            {{ $activity->status == 'pending' ? 'bg-amber-100 text-amber-600' :
                               ($activity->status == 'dipinjam' ? 'bg-blue-100 text-blue-600' :
                               ($activity->status == 'dikembalikan' || $activity->status == 'returned' ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-600')) }}">

                            @if($activity->status == 'pending')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            @elseif($activity->status == 'dipinjam')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                            @elseif($activity->status == 'dikembalikan' || $activity->status == 'returned')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                            @endif
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
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                </div>
                <h4 class="font-bold text-gray-900">1. Anggota</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Cek menu Verifikasi Siswa setiap pagi untuk menyetujui pendaftaran anggota baru.</p>
            </div>
            <div class="space-y-3">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                </div>
                <h4 class="font-bold text-gray-900">2. Sirkulasi Buku</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Proses pengajuan pinjaman masuk, tangani pengembalian, dan catat denda keterlambatan.</p>
            </div>
            <div class="space-y-3">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" /></svg>
                </div>
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
