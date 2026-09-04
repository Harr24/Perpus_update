<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Public\BookCatalogController;
use App\Http\Controllers\Admin\Petugas\VerificationController;
use App\Http\Controllers\Admin\Petugas\GenreController;
use App\Http\Controllers\Admin\Petugas\BookController;
use App\Http\Controllers\Admin\Superadmin\SuperadminPetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\Admin\Superadmin\MemberController;
use App\Http\Controllers\Admin\Petugas\TeacherController;
use App\Http\Controllers\Admin\Petugas\LoanApprovalController;
use App\Http\Controllers\Admin\Petugas\ReturnController;
use App\Http\Controllers\Admin\Petugas\FineController;
use App\Http\Controllers\Guru\LearningMaterialController;
use App\Http\Controllers\Admin\Superadmin\HeroSliderController;
use App\Http\Controllers\Admin\Petugas\BorrowingReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\Superadmin\SuperadminFineController;
use App\Http\Controllers\Admin\Superadmin\MajorController;
use App\Http\Controllers\Admin\Superadmin\ShelfController;
use App\Http\Controllers\Admin\Superadmin\HolidayController;
use App\Http\Controllers\Admin\Superadmin\ScheduleController;

// RUTE PUBLIK & TAMU
Route::get('/', [BookCatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/all', [BookCatalogController::class, 'allBooks'])->name('catalog.all');
Route::get('/book/{book}', [BookCatalogController::class, 'show'])->name('catalog.show');
Route::get('/book-cover/{book}', [BookCatalogController::class, 'showCover'])->name('book.cover');
Route::get('/materials', [BookCatalogController::class, 'allMaterials'])->name('catalog.materials.all');
Route::get('/pustakawan', [BookCatalogController::class, 'showLibrarians'])->name('catalog.librarians');

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('register/success', [AuthController::class, 'registrationSuccess'])->name('register.success');

    // Login Siswa/Guru/Petugas (Umum)
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // RUTE LUPA PASSWORD
    Route::get('forgot-password', [App\Http\Controllers\PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');

    // RUTE RESET PASSWORD (DARI LINK EMAIL)
    Route::get('reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('reset-password', [App\Http\Controllers\PasswordResetController::class, 'updatePassword'])->name('password.update');

    // RUTE SUPERADMIN
    Route::get('/portal-kendali-mcp', [AuthController::class, 'showSuperadminLogin'])->name('superadmin.login');
    Route::post('/portal-kendali-mcp', [AuthController::class, 'superadminLoginProcess'])->name('superadmin.login.process');
});

// RUTE UNTUK PENGGUNA YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markasread');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('leaderboard', [DashboardController::class, 'leaderboard'])->name('leaderboard');

    // RUTE PROFIL
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // HAPUS FOTO PROFIL
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    // --- TRUTE KATALOG INTERNAL (KHUSUS USER LOGIN) ---
    Route::get('/internal/catalog', [BookCatalogController::class, 'allBooks'])->name('internal.catalog.all');
    Route::get('/internal/book/{book}', [BookCatalogController::class, 'show'])->name('internal.catalog.show');
    Route::get('/internal/materials', [BookCatalogController::class, 'allMaterials'])->name('internal.catalog.materials');

    // RUTE PEMINJAMAN
    Route::post('/borrow/bulk', [BorrowingController::class, 'storeBulk'])->name('borrow.store.bulk');
    Route::get('/borrow/request/{book_copy}', [BorrowingController::class, 'create'])->name('borrow.create');
    Route::post('/borrow/{book_copy}', [BorrowingController::class, 'store'])->name('borrow.store');
    Route::get('/my-borrowings', [BorrowingController::class, 'index'])->name('borrow.history');

    // RUTE ROLE PETUGAS
    Route::middleware('role:petugas')->prefix('admin/petugas')->name('admin.petugas.')->group(function () {
        Route::get('/verifikasi-siswa', [VerificationController::class, 'index'])->name('verification.index');
        Route::post('/verifikasi-siswa/{user}/approve', [VerificationController::class, 'approve'])->name('verification.approve');
        Route::post('/verifikasi-siswa/{user}/reject', [VerificationController::class, 'reject'])->name('verification.reject');

        // RUTE SIRKULASI MEJA (PEMINJAMAN LANGSUNG OLEH PETUGAS)
        Route::get('/direct-borrow', [\App\Http\Controllers\Admin\Petugas\DirectBorrowController::class, 'create'])->name('direct_borrow.create');
        Route::get('/direct-borrow/{user}/books', [\App\Http\Controllers\Admin\Petugas\DirectBorrowController::class, 'selectBooks'])->name('direct_borrow.select_books');
        Route::post('/direct-borrow/{user}', [\App\Http\Controllers\Admin\Petugas\DirectBorrowController::class, 'store'])->name('direct_borrow.store');

        Route::resource('genres', GenreController::class)->except(['show']);

        Route::get('/books/create-bulk', [BookController::class, 'showCreateBulkForm'])->name('books.create.bulk');
        Route::post('/books/store-bulk', [BookController::class, 'storeBulkForm'])->name('books.store.bulk.form');

        Route::resource('books', BookController::class);
        Route::resource('teachers', TeacherController::class)->except(['show']);
        Route::delete('/book-copies/{copy}', [BookController::class, 'destroyCopy'])->name('books.copies.destroy');

        Route::put('/book-copies/{copy}/mark-found', [BookController::class, 'markCopyAsFound'])->name('books.copies.markFound');

        Route::get('/approvals', [LoanApprovalController::class, 'index'])->name('approvals.index');
        Route::post('/approvals/{borrowing}/approve', [LoanApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{borrowing}/reject', [LoanApprovalController::class, 'reject'])->name('approvals.reject');
        Route::post('/approvals/approve-multiple', [LoanApprovalController::class, 'approveMultiple'])->name('approvals.approveMultiple');

        Route::post('/approvals/reject-multiple', [LoanApprovalController::class, 'rejectMultiple'])->name('approvals.rejectMultiple');

        Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
        Route::put('/returns/{borrowing}', [ReturnController::class, 'store'])->name('returns.store');
        Route::put('/returns-multiple', [ReturnController::class, 'storeMultiple'])->name('returns.storeMultiple');
        Route::put('/returns/{borrowing}/mark-lost', [ReturnController::class, 'markAsLost'])->name('returns.markAsLost');

        Route::get('/fines', [FineController::class, 'index'])->name('fines.index');
        Route::post('/fines/{borrowing}/pay-installment', [FineController::class, 'payInstallment'])->name('fines.pay');
        Route::get('/fines/history', [FineController::class, 'history'])->name('fines.history');
        Route::get('/fines/history/export', [FineController::class, 'export'])->name('fines.export');

        Route::get('/reports/borrowings', [BorrowingReportController::class, 'index'])->name('reports.borrowings.index');
        Route::get('/reports/borrowings/export', [BorrowingReportController::class, 'export'])->name('reports.borrowings.export');
        Route::get('/reports/users/{user}/history', [BorrowingReportController::class, 'showUserHistory'])->name('reports.users.history');
    });

    // RUTE KHUSUS UNTUK ROLE GURU
    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::resource('materials', LearningMaterialController::class)->except(['show']);
    });

    // RUTE KHUSUS UNTUK ROLE SUPERADMIN
    Route::middleware('role:superadmin')->prefix('admin/superadmin')->name('admin.superadmin.')->group(function () {
        Route::resource('petugas', SuperadminPetugasController::class);

        Route::delete('/members/graduated', [MemberController::class, 'destroyGraduated'])->name('members.destroy.graduated');

        // update rute untuk halaman konfirmasi dan eksekusi naik kelas
        Route::get('/members/promotion-portal', [MemberController::class, 'showPromotionPortal'])->name('members.promotion.portal');
        Route::post('/members/promote-all', [MemberController::class, 'promoteAllStudents'])->name('members.promote.all');

        Route::resource('members', MemberController::class)->except(['create', 'store']);

        Route::resource('sliders', HeroSliderController::class);
        // Backup
        Route::get('/backup', [\App\Http\Controllers\Admin\Superadmin\BackupController::class, 'index'])->name('backup.index');
        Route::get('/backup/download', [\App\Http\Controllers\Admin\Superadmin\BackupController::class, 'downloadSql'])->name('backup.download');

        Route::get('/fines/history', [SuperadminFineController::class, 'history'])->name('fines.history');
        Route::delete('/fines/history/{fine}', [SuperadminFineController::class, 'destroy'])->name('fines.destroy');

        Route::get('/fines/history/export', [SuperadminFineController::class, 'export'])->name('fines.export');

        Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');
        Route::post('/holidays', [HolidayController::class, 'store'])->name('holidays.store');

        Route::get('/holidays/{holiday}/edit', [HolidayController::class, 'edit'])->name('holidays.edit');
        Route::put('/holidays/{holiday}', [HolidayController::class, 'update'])->name('holidays.update');

        Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy'])->name('holidays.destroy');

        Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
        Route::post('schedules', [ScheduleController::class, 'store'])->name('schedules.store');
        Route::delete('schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

        Route::resource('majors', MajorController::class)->except(['show']);

        Route::resource('shelves', ShelfController::class)->except(['show']);
    });
});
