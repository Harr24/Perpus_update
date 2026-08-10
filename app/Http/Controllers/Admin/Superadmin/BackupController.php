<?php

namespace App\Http\Controllers\Admin\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.superadmin.backup.index');
    }
    public function downloadSql()
    {
        try {
            // Ambil kredensial database dari file .env
            $dbName = env('DB_DATABASE');
            $userName = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST', '127.0.0.1');

            // Format nama file: backup_multicomp_YYYY_MM_DD_HHMMSS.sql
            $fileName = 'backup_multicomp_' . date('Y_m_d_His') . '.sql';

            // Simpan sementara di storage/app/
            $filePath = storage_path('app/' . $fileName);

            // Inisialisasi library mysqldump-php
            $dump = new IMysqldump\Mysqldump("mysql:host={$host};dbname={$dbName}", $userName, $password);

            // Proses pembuatan file .sql
            $dump->start($filePath);

            // Download file tersebut ke laptop/HP, lalu otomatis hapus file sementaranya dari server
            return response()->download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat backup database: ' . $e->getMessage());
        }
    }
}
