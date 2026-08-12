<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// Import Model yang sudah kita pastikan benar
use App\Models\Book;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama dengan data yang relevan untuk setiap role.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $data = []; // Inisialisasi array untuk data tambahan

        // Siapkan data spesifik berdasarkan role pengguna
        switch ($user->role) {

            // BLOK LOGIN SUPERADMIN (Fitur 1, 3, dan 5)
            case 'superadmin':
                // 1. DATA STATISTIK UTAS
                // variabel view superadmin
                $data['totalBuku'] = Book::count();
                $data['anggotaAktif'] = User::whereIn('role', ['siswa', 'guru'])
                                            ->where('account_status', 'active')
                                            ->count();
                $data['pengajuanPinjaman'] = Borrowing::where('status', 'pending')
                                                      ->count();
                $data['terlambat'] = Borrowing::where('status', 'dipinjam')
                                            ->where('due_at', '<', now())
                                            ->count();

                // ----------------------------------------------------------
                // 3 GRAFIK PERTUMBUHAN ANGGOTA (Line Chart)
                // ----------------------------------------------------------
                $currentYear = Carbon::now()->year;

                // Ambil data user baru (siswa/guru) dikelompokkan per bulan tahun ini
                $usersPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                    ->whereYear('created_at', $currentYear)
                    ->whereIn('role', ['siswa', 'guru'])
                    ->groupBy('month')
                    ->pluck('count', 'month');

                $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                $growthData = [];

                // Looping 12 bulan untuk memastikan array terisi penuh (isi 0 jika kosong)
                for ($m = 1; $m <= 12; $m++) {
                    $growthData[] = $usersPerMonth->get($m, 0);
                }

                $data['monthLabels'] = $monthLabels;
                $data['growthData'] = $growthData;
                $data['currentYear'] = $currentYear;

                // Fitur 1: GRAFIK EFEKTIVITAS SMART DUE DATE (Doughnut)
                // Menghitung rasio tepat waktu vs terlambat dari semua transaksi

                // A. Tepat Waktu: Sudah kembali && tanggal kembali <= tenggat
                $onTime = Borrowing::where('status', 'returned')
                                    ->whereRaw('returned_at <= due_at')
                                    ->count();

                // B. Terlambat (Total):
                //    - Sudah kembali tapi telat (returned_at > due_at)
                //    - BELUM kembali tapi sudah lewat tenggat (status dipinjam && due_at < now)
                $lateReturned = Borrowing::where('status', 'returned')
                                         ->whereRaw('returned_at > due_at')
                                         ->count();
                $lateNotReturned = Borrowing::where('status', 'dipinjam')
                                            ->where('due_at', '<', now())
                                            ->count();

                $totalLate = $lateReturned + $lateNotReturned;

                // Data untuk Chart.js [Tepat Waktu, Terlambat]
                $data['smartDueDateData'] = [$onTime, $totalLate];

                // Fitur 5: WIDGET LOG AUDIT SISTEM (Simulasi)
                // Karena belum ada tabel AuditLog,simulasikan dengan mengambil
                // aktivitas master data terbaru: Anggota Baru & Buku Baru.

                // Ambil 3 pendaftaran anggota terbaru
                $latestUsers = User::latest()->take(3)->get()->map(function($item) {
                    return (object) [
                        'type' => 'user',
                        'icon' => '👤',
                        'message' => 'Anggota baru terdaftar: ' . Str::limit($item->name, 30),
                        'time' => $item->created_at
                    ];
                });

                // Ambil 3 penambahan buku terbaru
                $latestBooks = Book::latest()->take(3)->get()->map(function($item) {
                    return (object) [
                        'type' => 'book',
                        'icon' => '📚',
                        'message' => 'Buku baru ditambahkan: ' . Str::limit($item->title, 30),
                        'time' => $item->created_at
                    ];
                });

                // Gabungkan, urutkan berdasarkan waktu terbaru, ambil 5 teratas
                $data['auditLogs'] = $latestUsers->concat($latestBooks)
                                                 ->sortByDesc('time')
                                                 ->take(5);
                break;

            // BLOK LOGIKA ASLI UNTUK PETUGAS
            case 'petugas':
                // 1. DATA STATISTIK ATAS
                $data['pendingStudentsCount'] = User::where('role', 'siswa')
                                                    ->where('account_status', 'pending')
                                                    ->count();
                $data['totalBuku'] = Book::count();
                $data['anggotaAktif'] = User::whereIn('role', ['siswa', 'guru'])
                                            ->where('account_status', 'active')
                                            ->count();
                $data['pengajuanPinjaman'] = Borrowing::where('status', 'pending')
                                                      ->count();
                $data['terlambat'] = Borrowing::where('status', 'dipinjam')
                                            ->where('due_at', '<', now())
                                            ->count();

                // 2. DATA GRAFIK GARIS (PEMINJAMAN BULAN INI)
                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;
                $daysInMonth = Carbon::now()->daysInMonth;

                $borrowingsThisMonth = Borrowing::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->groupBy('date')
                    ->pluck('count', 'date');

                $chartLabels = [];
                $chartData = [];

                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $dateString = Carbon::createFromDate($currentYear, $currentMonth, $i)->toDateString();
                    $chartLabels[] = $i;
                    $chartData[] = $borrowingsThisMonth->get($dateString, 0);
                }

                $data['chartLabels'] = $chartLabels;
                $data['chartData'] = $chartData;
                $data['currentMonthName'] = Carbon::now()->translatedFormat('F Y');

                // 3. DATA GRAFIK DONAT (GENRE BUKU TERLARIS)
                $topGenres = DB::table('genres')
                    ->join('books', 'genres.id', '=', 'books.genre_id')
                    ->join('book_copies', 'books.id', '=', 'book_copies.book_id')
                    ->join('borrowings', 'book_copies.id', '=', 'borrowings.book_copy_id')
                    ->whereNotIn('borrowings.status', ['pending', 'ditolak']) // Hanya hitung yang disetujui
                    ->select('genres.name', DB::raw('COUNT(borrowings.id) as total'))
                    ->groupBy('genres.id', 'genres.name')
                    ->orderByDesc('total')
                    ->take(5) // Ambil 5 genre teratas saja
                    ->get();

                // Ubah data menjadi array agar mudah dibaca Chart.js
                $data['genreLabels'] = $topGenres->pluck('name')->toArray();
                $data['genreData'] = $topGenres->pluck('total')->toArray();

                //  4. MONITOR GAMIFIKASI (3 BESAR PEMBACA)
                $data['topReaders'] = User::where('role', 'siswa')
                    ->where('account_status', 'active')
                    ->withCount(['borrowings' => function($q) {
                        $q->whereNotIn('status', ['pending', 'ditolak']);
                    }])
                    ->orderByDesc('borrowings_count')
                    ->take(3)
                    ->get();

                // 5. WIDGET NOTIFIKASI (5 AKTIVITAS TERBARU)

                $data['recentActivities'] = Borrowing::with(['user', 'bookCopy.book'])
                    ->latest('created_at')
                    ->take(5)
                    ->get();
                break;

            case 'siswa':
            case 'guru':

                // DATA DASHBOARD SISWA
                $data['favoriteBooks'] = Book::with('genre')
                    ->where('book_type', 'reguler')
                    ->withCount([
                        'copies as available_copies_count' => function ($query) {
                            $query->where('status', 'tersedia');
                        },
                        'borrowings' => function ($query) {
                            $query->where('borrowings.status', '!=', 'pending')
                                  ->where('borrowings.status', '!=', 'ditolak');
                        }
                    ])
                    ->orderByDesc('borrowings_count')
                    ->limit(10)
                    ->get();

                $data['hasBorrowings'] = $user->borrowings()->exists();

                $activeBorrowings = $user->borrowings()
                                        ->where('status', 'dipinjam')
                                        ->with('bookCopy.book')
                                        ->latest('borrowed_at')
                                        ->get();

                if ($activeBorrowings->isNotEmpty()) {
                    if ($user->role == 'guru') {
                        $groupedBorrowings = $activeBorrowings->groupBy('bookCopy.book_id')
                            ->map(function ($items) {
                                $firstItem = $items->first();
                                if ($firstItem && $firstItem->bookCopy && $firstItem->bookCopy->book) {
                                    return (object) [
                                        'book' => $firstItem->bookCopy->book,
                                        'count' => $items->count(),
                                        'earliest_borrowed' => $items->min('borrowed_at'),
                                        'latest_due' => $items->max('due_at'),
                                    ];
                                }
                                return null;
                            })->filter();

                        $data['borrowingInfo'] = $groupedBorrowings;
                        $data['displayMode'] = 'grouped';
                    } else {
                        $data['borrowingInfo'] = $activeBorrowings;
                        $data['displayMode'] = 'individual';
                    }
                } else {
                    $data['borrowingInfo'] = null;
                    $data['displayMode'] = null;
                    $quote = [
                        'content' => 'Membaca adalah jendela dunia. Semakin banyak membaca, semakin banyak kita tahu.',
                        'author' => 'Pribahasa'
                    ];
                    $data['quote'] = $quote;
                }
                break;
        }

        // Kirim semua data ke view
        return view('dashboard', array_merge(['user' => $user], $data));
    }
}
