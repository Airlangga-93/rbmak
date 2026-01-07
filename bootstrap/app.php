<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // Import ini wajib ada

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        /**
         * 1. JIKA USER BELUM LOGIN (GUEST)
         * Jika mereka mencoba mengakses halaman yang diproteksi (middleware auth),
         * arahkan mereka ke halaman login booking.
         */
        $middleware->redirectGuestsTo(fn (Request $request) => route('booking.login'));

        /**
         * 2. JIKA USER SUDAH LOGIN (AUTHENTICATED)
         * Jika mereka sudah login tapi nekat buka halaman /login lagi,
         * arahkan ke dashboard yang sesuai agar tidak terlempar ke welcome.
         */
        $middleware->redirectUsersTo(function (Request $request) {
            // Jika dia sedang mengakses area admin, arahkan ke dashboard admin
            if ($request->is('admin') || $request->is('admin/*') || $request->is('login')) {
                return route('admin.dashboard');
            }

            // Default untuk user booking
            return route('booking.index');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
