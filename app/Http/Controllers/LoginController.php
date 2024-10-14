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
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->active == 0) {
                return redirect()->route('auth.login')->with('error', 'Your Account was inactive, contact your admin');
            }

            if ($user->role == 0) {
                return redirect()->route('admin.dashboard')->with('success','Login Success, Hallo '. Auth::user()->name);
            } elseif ($user->role == 1) {
                return redirect()->route('pegawai.dashboard')->with('success','Login Success, Hallo '. Auth::user()->name);
            } elseif ($user->role == 2) {
                return redirect()->route('atasan.dashboard')->with('success','Login Success, Hallo '. Auth::user()->name);
            }
        } else {
            return redirect()->route('auth.login')->with('error', 'Username atau Password anda salah!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login')->with('success', 'Kamu berhasil Logout');
    }

}
