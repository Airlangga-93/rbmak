<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // 1. Validasi input email
        $request->validate(['email' => 'required|email']);

        // 2. Cek apakah email ada di database (hasil AdminUserSeeder)
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
        }

        // 3. Generate 6-digit code (OTP)
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // 4. Simpan atau Update kode di tabel password_reset_codes
        // Pastikan migration Anda sudah memiliki kolom 'expires_at'
        DB::table('password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            [
                'code' => $code,
                'created_at' => now(),
                'expires_at' => now()->addMinutes(10)
            ]
        );

        // 5. Kirim email dengan kode
        try {
            Mail::raw("Kode reset password Anda: {$code}\n\nKode ini akan kadaluarsa dalam 10 menit.", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Kode Reset Password - PT Sayap Sembilan Satu');
            });

            // PERBAIKAN UTAMA: Sertakan ['email' => $request->email] di dalam route
            // Ini agar halaman verifikasi bisa menangkap email tersebut melalui request('email')
            return redirect()->route('password.verify', ['email' => $request->email])
                             ->with('status', 'Kode reset password telah dikirim ke email Anda.');

        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi nanti.']);
        }
    }
}
