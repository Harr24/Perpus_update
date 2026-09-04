<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class PasswordResetController extends Controller
{
    // 1. Menampilkan form input email (Halaman Publik - Bootstrap)
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Memproses email dan mengirim link reset
    public function sendResetLink(Request $request)
    {
        // Validasi: Pastikan email diisi dan ADA di tabel users
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        // Buat token acak sepanjang 64 karakter
        $token = Str::random(64);

        // Simpan email dan token ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email], // Cari berdasarkan email
            [
                'token' => $token,        // Simpan token baru
                'created_at' => Carbon::now()
            ]
        );

        // Kirim Email berisi link reset
        Mail::send('emails.reset-password', ['token' => $token, 'email' => $request->email], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password - Perpustakaan Multicomp');
        });

        return back()->with('success', 'Link reset password telah dikirim ke email Anda! Silakan cek kotak masuk atau folder spam.');
    }

    // 3. Menampilkan form input password baru (Setelah link di email diklik)
    public function resetForm(Request $request, $token)
    {
        // Ambil email dari parameter URL (?email=xxx)
        $email = $request->query('email');
        return view('auth.reset-password', compact('token', 'email'));
    }

    // 4. Memproses perubahan password ke database
    public function updatePassword(Request $request)
    {
        // Validasi inputan password baru
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed', // Harus ada input 'password_confirmation'
            'token' => 'required'
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Cek apakah token dan email cocok di database
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->with('error', 'Token reset password tidak valid atau sudah kadaluarsa.');
        }

        // Update password di tabel users (wajib di-Hash)
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token agar tidak bisa digunakan dua kali
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }
}
