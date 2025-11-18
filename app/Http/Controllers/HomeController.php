<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user(); // atau auth()->user()

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('member')) {
            return redirect()->route('member.dashboard');
        }

        return view('dashboard');
    }

    public function index()
    {
        return view('home');
    }
}
