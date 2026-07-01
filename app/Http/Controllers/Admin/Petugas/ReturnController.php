<?php

namespace App\Http\Controllers\Admin\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\BookCopy;

class ReturnController extends Controller
{
    /**
     * Menampilkan daftar buku yang sedang dipinjam, dengan fungsionalitas PENCARIAN & FILTER.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterType = $request->input('filter_type');
        $filterStatus = $request->input('filter_status');

        $query = Borrowing::whereIn('status', ['dipinjam', 'overdue'])
                        ->with('user', 'bookCopy.book');

        // 1. Logika Pencarian (Nama, NIS, atau Judul Buku)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($subq) use ($search) {
                    $subq->where('name', 'like', '%' . $search . '%')
                         ->orWhere('nis', 'like', '%' . $search . '%');
                })
                ->orWhereHas('bookCopy.book', function ($subq) use ($search) {
                    $subq->where('title', 'like', '%' . $search . '%');
                });
            });
        }

        // 2. Logika Filter Tipe Buku (Reguler, Paket, Laporan)
        if ($filterType) {
            $query->whereHas('bookCopy.book', function ($q) use ($filterType) {
                $q->where('book_type', $filterType);
            });
        }

        // 3. Logika Filter Status Keterlambatan
        if ($filterStatus) {
            $today = Carbon::today()->format('Y-m-d');

            if ($filterStatus == 'terlambat') {
                // Yang telat: Jatuh tempo < hari ini, BUKAN guru, dan BUKAN buku laporan
                $query->whereDate('due_date', '<', $today)
                      ->whereHas('user', function($q) {
                          $q->where('role', '!=', 'guru');
                      })
                      ->whereHas('bookCopy.book', function($q) {
                          $q->where('book_type', '!=', 'laporan');
                      });
            } elseif ($filterStatus == 'aman') {
                // Yang aman: Belum jatuh tempo ATAU Guru ATAU Buku Laporan
                $query->where(function($q) use ($today) {
                    $q->whereDate('due_date', '>=', $today)
                      ->orWhereNull('due_date')
                      ->orWhereHas('user', function($userQ) {
                          $userQ->where('role', 'guru');
                      })
                      ->orWhereHas('bookCopy.book', function($bookQ) {
                          $bookQ->where('book_type', 'laporan');
                      });
                });
            }
        }

        // Pengurutan berdasarkan user_id agar fitur "Pilih Semua per User" bekerja
        $activeBorrowings = $query->orderBy('user_id', 'asc')
                                 ->latest('approved_at')
                                 ->get();

        $holidays = DB::table('holidays')
                    ->pluck('holiday_date')
                    ->map(fn($dateStr) => (new Carbon($dateStr))->format('Y-m-d'));

        return view('admin.petugas.returns.index', [
            'activeBorrowings' => $activeBorrowings,
            'search' => $search,
            'filterType' => $filterType,
            'filterStatus' => $filterStatus,
            'holidays' => $holidays,
            'today' => Carbon::today()
        ]);
    }

    /**
     * Memproses pengembalian buku tunggal.
     */
    public function store(Borrowing $borrowing)
    {
        if (!in_array($borrowing->status, ['dipinjam', 'overdue'])) {
            return redirect()->back()->with('error', 'Peminjaman ini tidak dalam status aktif.');
        }

        $holidayDates = DB::table('holidays')
                        ->pluck('holiday_date')
                        ->map(fn($dateStr) => (new Carbon($dateStr))->format('Y-m-d'))
                        ->toArray();

        $borrowing->loadMissing('user');

        DB::transaction(function () use ($borrowing, $holidayDates) {
            $returnDate = Carbon::now();
            $book = $borrowing->bookCopy->book;
            $dueDate = $borrowing->due_date ? Carbon::parse($borrowing->due_date) : null;

            $lateDays = 0;
            $fine = 0;

            if (
                $borrowing->user && $borrowing->user->role !== 'guru' &&
                $book->book_type != 'laporan' &&
                $dueDate &&
                $returnDate->isAfter($dueDate)
            ) {
                $lateDays = $dueDate->diffInDaysFiltered(function (Carbon $date) use ($holidayDates) {
                    $isWeekend = $date->isSaturday() || $date->isSunday();
                    $isHoliday = in_array($date->format('Y-m-d'), $holidayDates);
                    return !$isWeekend && !$isHoliday;
                }, $returnDate);

                $fine = $lateDays * 1000;
            }

            $borrowing->status = 'returned';
            $borrowing->returned_at = $returnDate;
            $borrowing->fine_amount = $fine;
            $borrowing->late_days = $lateDays;
            $borrowing->returned_by = Auth::id();
            $borrowing->fine_status = ($fine > 0) ? 'unpaid' : 'paid';
            $borrowing->save();

            $bookCopy = $borrowing->bookCopy;
            $bookCopy->status = 'tersedia';
            $bookCopy->save();
        });

        $message = 'Buku berhasil dikembalikan.';
        if ($borrowing->fine_amount > 0) {
            $message .= ' Denda keterlambatan sebesar Rp ' . number_format($borrowing->fine_amount, 0, ',', '.') . ' tercatat.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Memproses pengembalian buku massal.
     */
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'borrowing_ids' => 'required|array',
            'borrowing_ids.*' => 'exists:borrowings,id',
        ]);

        $borrowingIds = $request->input('borrowing_ids');

        $borrowingsToReturn = Borrowing::with('user')
                                ->whereIn('id', $borrowingIds)
                                ->whereIn('status', ['dipinjam', 'overdue'])
                                ->get();

        if ($borrowingsToReturn->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada buku valid yang dipilih untuk dikembalikan.');
        }

        $holidayDates = DB::table('holidays')
                        ->pluck('holiday_date')
                        ->map(fn($dateStr) => (new Carbon($dateStr))->format('Y-m-d'))
                        ->toArray();

        $totalReturned = 0;
        $totalFine = 0;
        $petugasId = Auth::id();

        DB::transaction(function () use ($borrowingsToReturn, &$totalReturned, &$totalFine, $petugasId, $holidayDates) {
            foreach ($borrowingsToReturn as $borrowing) {
                $returnDate = Carbon::now();
                $book = $borrowing->bookCopy->book;
                $dueDate = $borrowing->due_date ? Carbon::parse($borrowing->due_date) : null;

                $lateDays = 0;
                $fine = 0;

                if (
                    $borrowing->user && $borrowing->user->role !== 'guru' &&
                    $book->book_type != 'laporan' &&
                    $dueDate &&
                    $returnDate->isAfter($dueDate)
                ) {
                    $lateDays = $dueDate->diffInDaysFiltered(function (Carbon $date) use ($holidayDates) {
                        $isWeekend = $date->isSaturday() || $date->isSunday();
                        $isHoliday = in_array($date->format('Y-m-d'), $holidayDates);
                        return !$isWeekend && !$isHoliday;
                    }, $returnDate);

                    $fine = $lateDays * 1000;
                }

                $totalFine += $fine;
                $borrowing->status = 'returned';
                $borrowing->returned_at = $returnDate;
                $borrowing->fine_amount = $fine;
                $borrowing->late_days = $lateDays;
                $borrowing->returned_by = $petugasId;
                $borrowing->fine_status = ($fine > 0) ? 'unpaid' : 'paid';
                $borrowing->save();

                $bookCopy = $borrowing->bookCopy;
                $bookCopy->status = 'tersedia';
                $bookCopy->save();

                $totalReturned++;
            }
        });

        $message = $totalReturned . ' buku berhasil dikembalikan.';
        if ($totalFine > 0) {
            $message .= ' Total denda keterlambatan yang tercatat sebesar Rp ' . number_format($totalFine, 0, ',', '.');
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Menandai Buku Hilang
     */
    public function markAsLost(Borrowing $borrowing)
    {
        if (!in_array($borrowing->status, ['dipinjam', 'overdue'])) {
            return redirect()->back()->with('error', 'Peminjaman ini tidak dalam status aktif.');
        }

        $lostFineAmount = 0;

        DB::transaction(function () use ($borrowing, $lostFineAmount) {
            $processDate = Carbon::now();

            $bookCopy = $borrowing->bookCopy;
            if ($bookCopy) {
                $bookCopy->status = 'hilang';
                $bookCopy->save();
            } else {
                 throw new \Exception("Data eksemplar buku tidak ditemukan untuk peminjaman ID: {$borrowing->id}");
            }

            $borrowing->status = 'missing';
            $borrowing->returned_at = $processDate;
            $borrowing->late_days = 0;
            $borrowing->fine_amount = $lostFineAmount;
            $borrowing->fine_status = 'paid';
            $borrowing->returned_by = Auth::id();
            $borrowing->save();
        });

        $bookTitle = $borrowing->bookCopy && $borrowing->bookCopy->book ? $borrowing->bookCopy->book->title : '[Judul Tidak Ditemukan]';
        $bookCode = $borrowing->bookCopy ? $borrowing->bookCopy->book_code : '[Kode Tidak Ditemukan]';

        $message = "Buku '{$bookTitle}' (Eksemplar: {$bookCode}) berhasil ditandai sebagai HILANG.";
        return redirect()->back()->with('success', $message);
    }
}
