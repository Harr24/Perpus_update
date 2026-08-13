<?php

namespace App\Http\Controllers\Admin\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectBorrowController extends Controller
{
    public function create(Request $request)
    {
        $search = $request->input('search');
        $members = collect();

        if ($search) {
            $members = User::whereIn('role', ['siswa', 'guru'])
                ->where('account_status', 'active')
                ->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nis', 'like', "%{$search}%");
                })
                ->orderBy('name')
                ->take(10)
                ->get();
        }
        return view('admin.petugas.direct_borrow.create', compact('members', 'search'));
    }

    public function selectBooks(Request $request, User $user)
    {
        if ($user->account_status !== 'active') {
            return redirect()->route('admin.petugas.direct_borrow.create')->with('error', 'Akun anggota tidak aktif.');
        }

        $search = $request->input('search');
        $query = Book::whereHas('copies', function($q) {
                        $q->where('status', 'tersedia');
                     })
                     ->with(['copies' => function($q) {
                        $q->where('status', 'tersedia')->orderBy('book_code');
                     }]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Limit data jadi 5 saja per halaman agar tidak berat
        $books = $query->paginate(5)->withQueryString();

        return view('admin.petugas.direct_borrow.select_books', compact('user', 'books', 'search'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'book_copy_ids' => 'required|array|min:1',
            'book_copy_ids.*' => 'exists:book_copies,id'
        ]);

        $copyIds = $request->book_copy_ids;
        $jumlahDipinjam = count($copyIds);

        // Batas maksimal 3 buku khusus untuk Siswa
        if ($user->role == 'siswa') {
            $activeLoanCount = Borrowing::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'dipinjam', 'overdue'])->count();
            if (($activeLoanCount + $jumlahDipinjam) > 3) {
                return redirect()->back()->with('error', "Maksimal peminjaman adalah 3 buku.");
            }
        }

        try {
            DB::transaction(function () use ($user, $copyIds) {
                $copies = BookCopy::whereIn('id', $copyIds)->where('status', 'tersedia')->lockForUpdate()->get();

                foreach ($copies as $copy) {
                    //  LOGIKA BATAS WAKTU (JATUH TEMPO)
                    // 1. Jika peminjam adalah Guru -> Tidak ada batas waktu (null)
                    // 2. Jika tipe buku adalah Laporan -> Tidak ada batas waktu (null)
                    // 3. Selain kondisi di atas (Siswa pinjam Reguler/Paket) -> 7 Hari Kerja
                    $dueDate = null;

                    if ($user->role !== 'guru' && $copy->book->book_type !== 'laporan') {
                        $dueDate = Carbon::now();
                        $daysAdded = 0;

                        // Hitung 7 Hari (Skip Sabtu & Minggu)
                        while ($daysAdded < 7) {
                            $dueDate->addDay();
                            if (!$dueDate->isSaturday() && !$dueDate->isSunday()) {
                                $daysAdded++;
                            }
                        }
                    }
                    // ==========================================================

                    $copy->update(['status' => 'dipinjam']);

                    Borrowing::create([
                        'user_id' => $user->id,
                        'book_copy_id' => $copy->id,
                        'borrowed_at' => Carbon::now(),
                        'due_at' => $dueDate, // Bisa null
                        'due_date' => $dueDate ? $dueDate->format('Y-m-d') : null, // Memastikan halaman pengembalian bisa membaca tanggal
                        'status' => 'dipinjam',
                        'approved_at' => Carbon::now(),
                        'approved_by' => Auth::id()
                    ]);
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.petugas.direct_borrow.create')->with('success', "Berhasil dipinjamkan.");
    }
}
