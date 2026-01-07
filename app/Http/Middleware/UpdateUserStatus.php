<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sedang login, update waktu aktif terakhirnya
        if (Auth::check()) {
            Auth::user()->update([
                'last_seen' => now()
            ]);
        }

        return $next($request);
    }
}
