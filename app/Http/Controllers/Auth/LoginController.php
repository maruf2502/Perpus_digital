<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    $request->validate([
        'email'     => 'required|email',
        'password'  => 'required'
    ]);

    $credentials = [
        'email'     => $request->email,
        'password'  => $request->password
    ];

    if (Auth::guard('member')->attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::guard('member')->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('member')) {
            return redirect()->route('member.dashboard');
        } else {
            return redirect()->route('login')->with('failed', 'Role tidak dikenali');
        }
    } else {
        return redirect()->route('login')->with('failed', 'Email atau password salah');
    }
}

   public function logout(Request $request)
{
    // Jika member sedang login
    if (Auth::guard('member')->check()) {
        Auth::guard('member')->logout();
    }

    // Jika admin sedang login
    if (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Kamu berhasil logout');
    }

}
