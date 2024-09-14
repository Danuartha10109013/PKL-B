<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        // dd($request->all());
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $data = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            
            // Cek peran pengguna setelah login berhasil
            if ($user->active == 0) {
                return redirect()->route('auth.login')->with('failed', 'Your Account was inactive, contact your admin');
            }
        
            // Redirect sesuai peran pengguna jika status aktif
            if ($user->role == 0) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role == 1) {
                return redirect()->route('pegawai.dashboard');
            } elseif ($user->role == 2) {
                return redirect()->route('atasan.dashboard');
            }
        } else {
            // Redirect kembali ke halaman login jika gagal
            return redirect()->route('auth.login')->with('failed', 'Username atau Password anda salah!');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login')->with('succes', 'Kamu berhasil Logout');
    }
}
