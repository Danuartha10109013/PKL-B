<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPegawai
{
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna adalah pegawai (role = 1)
        if (Auth::check()) {
            if (Auth::user()->role == 1){
                return $next($request);
            }
            return response()->view('errors.custom', ['message' => 'Anda Bukan Admin'], 403);
        }
        return redirect('/');; // Ganti dengan kode status atau rute yang sesuai
    }
}
