<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <-- Ini kode Paginator

// ===========================================
// --- Import Model & Observer ---
// ===========================================
use App\Models\Borrowing;
use App\Observers\BorrowingObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // (Kosong itu normal)
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Kode Paginator
        Paginator::useBootstrapFive();

        // Kode Observer
        Borrowing::observe(BorrowingObserver::class);
    }
}
