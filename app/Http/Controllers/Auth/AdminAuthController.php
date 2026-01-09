<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;

class AdminAuthController extends Controller
{
    use ThrottlesLogins;

    // Batasan Ketat
    protected $maxAttempts = 3;  // 3 kali salah langsung blokir
    protected $decayMinutes = 5; // Blokir selama 5 menit

    /**
     * Kunci identitas pengakses (IP Address)
     */
    protected function throttleKey(Request $request)
    {
        // Mengunci berdasarkan IP agar meskipun ganti email, tetap diblokir
        return 'login_attempt_' . $request->ip();
    }

    /**
     * Tampilan Form Login
     */
    public function showLoginForm(Request $request)
    {
        // CEK APAKAH IP SEDANG DIBLOKIR
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));

            // Jika diblokir, jangan kasih form login, lempar ke halaman error
            abort(429, "AKSES ILEGAL TERDETEKSI! IP Anda ({$request->ip()}) telah diblokir otomatis oleh sistem keamanan karena percobaan login berulang. Silakan kembali dalam {$seconds} detik.");
        }

        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Cek Lockout (Apakah sudah kena blokir?)
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = RateLimiter::availableIn($this->throttleKey($request));

            return abort(429, "IP ANDA DIBLOKIR! Terlalu banyak percobaan masuk. Tunggu {$seconds} detik.");
        }

        $credentials = $request->only('email', 'password');

        // 2. Percobaan Autentikasi
        if (Auth::attempt($credentials, $request->filled('remember'))) {

            // Cek Role Admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout();

                // Jika bukan admin tapi coba masuk, anggap sebagai percobaan gagal
                $this->incrementLoginAttempts($request);

                return back()->withErrors([
                    'email' => 'PERINGATAN: Anda tidak memiliki akses Administrator!',
                ]);
            }

            // Sukses Login
            $this->clearLoginAttempts($request);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Jika Gagal Login
        $this->incrementLoginAttempts($request);

        $attemptsMade = RateLimiter::attempts($this->throttleKey($request));
        $attemptsLeft = $this->maxAttempts - $attemptsMade;

        if ($attemptsLeft <= 0) {
             return abort(429, "SISTEM TERKUNCI! Anda telah menghabiskan semua kesempatan login.");
        }

        return back()->withErrors([
            'email' => "Login Gagal! Sisa kesempatan: {$attemptsLeft} kali lagi sebelum IP Anda diblokir total.",
        ])->withInput($request->only('email'));
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesi admin berakhir.');
    }
}
