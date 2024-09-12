<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AutoLogout
{
    public function handle($request, Closure $next)
    {
        $timeout = 120; // dalam menit

        // Jika pengguna telah login
        if (Auth::check()) {
            $lastActivity = Session::get('lastActivityTime');
            $currentTime = now();

            // Jika tidak ada aktivitas dalam 2 jam
            if ($lastActivity && $currentTime->diffInMinutes($lastActivity) > $timeout) {
                Auth::logout();
                Session::flush();

                return redirect('/login')->with('message', 'Session expired due to inactivity.');
            }

            // Update waktu aktivitas terakhir
            Session::put('lastActivityTime', $currentTime);
        }

        return $next($request);
    }
}
