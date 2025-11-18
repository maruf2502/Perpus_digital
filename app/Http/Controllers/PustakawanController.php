<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PustakawanController extends Controller
{
    public function index()
    {
        return view('pustakawan.dashboard');
    }
}
