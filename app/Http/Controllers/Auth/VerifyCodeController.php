<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class VerifyCodeController extends Controller
{
    /**
     * Menampilkan form input kode verifikasi.
     */
    public function showVerifyForm()
    {
        return view('auth.passwords.verify');
    }

    /**
     * Verifikasi kode OTP.
     */
    public function verifyCode(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
        ]);

        // 2. Cari kode di database yang sesuai email dan kodenya
        $resetCode = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        // 3. Cek apakah data ada
        if (!$resetCode) {
            return back()->withErrors(['code' => 'Kode verifikasi tidak valid.']);
        }

        // 4. Cek apakah sudah melewati batas 'expires_at'
        if (now()->gt($resetCode->expires_at)) {
            return back()->withErrors(['code' => 'Kode verifikasi telah kadaluarsa. Silakan minta kode baru.']);
        }

        // 5. Simpan email di session agar halaman 'Change Password' tahu siapa yang ganti
        session(['reset_email' => $request->email]);

        return redirect()->route('password.change');
    }

    /**
     * Menampilkan form ganti password baru.
     */
    public function showChangePasswordForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi berakhir, silakan masukkan email kembali.']);
        }

        return view('auth.passwords.change');
    }

    /**
     * Eksekusi perubahan password.
     */
    public function changePassword(Request $request)
    {
        // Validasi password baru
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'User tidak ditemukan.']);
        }

        // Update password user
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus kode dari database agar tidak bisa dipakai lagi (Keamanan)
        DB::table('password_reset_codes')->where('email', $email)->delete();

        // Bersihkan session
        session()->forget('reset_email');

        return redirect()->route('login')->with('status', 'Password berhasil diperbarui. Silakan login dengan password baru Anda.');
    }
}
