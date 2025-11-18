<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class DaftarbukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        return view('daftarbuku.index', compact('bukus'));
    }
     public function create()
    {
        return view('daftarbuku.create');
    }
    public function store(request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:9000',

        ]);

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,


        ]);

        return redirect()->route('admin.bukus.index')->with('success', 'Buku berhasil ditambahkan');
    }
}
