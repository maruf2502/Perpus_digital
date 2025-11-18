<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Member;

class PeminjamanbukuController extends Controller
{
    // Menampilkan daftar buku yang bisa dipinjam (dengan fitur search)
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bukus = Buku::when($search, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%')
                         ->orWhere('penulis', 'like', '%' . $search . '%');
        })->get();

        $members = Member::all(); // Jika masih digunakan
        return view('peminjamanbuku.index', compact('bukus', 'members'));
    }

    // Menampilkan form manual untuk meminjam buku
    public function create()
    {
        $bukus = Buku::where('status', 'tersedia')->get();
        $members = Member::all();
        return view('peminjamanbuku.form', compact('bukus', 'members'));
    }

    // Menyimpan data peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'member_id' => 'required|exists:members,id',
        ]);

        $buku = Buku::find($request->buku_id);

        // Jika buku sudah dipinjam
        if ($buku->status === 'dipinjam') {
            return redirect()->back()->with('failed', 'Buku sedang dipinjam.');
        }

        // Simpan peminjaman
        Peminjaman::create([
            'buku_id' => $buku->id,
            'member_id' => $request->member_id,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(7),
        ]);

        // Update status buku
        $buku->update(['status' => 'dipinjam']);

        return redirect()->route('peminjamanbuku.index')->with('success', 'Buku berhasil dipinjam.');
    }
}
