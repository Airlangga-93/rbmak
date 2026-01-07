<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * LOGIKA ONLINE STATUS
         * Setiap kali ada halaman yang dimuat (View Rendered),
         * kita cek apakah user sedang login. Jika iya, update waktu terakhir terlihat.
         */
        View::composer('*', function () {
            if (Auth::check()) {
                // Menggunakan update senyap (tanpa menyentuh updated_at utama jika tidak perlu)
                // atau langsung update kolom last_seen
                Auth::user()->update([
                    'last_seen' => now()
                ]);
            }
        });
    }
}
