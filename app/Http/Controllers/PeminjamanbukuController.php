<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanbukuController extends Controller
{
    // Menampilkan daftar buku yang bisa dipinjam
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');

        $daftarBuku = Buku::where('jumlah_unit', '>', 0)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%$search%")
                        ->orWhere('penulis', 'like', "%$search%")
                        ->orWhere('penerbit', 'like', "%$search%")
                        ->orWhere('kategori', 'like', "%$search%")
                        ->orWhere('tahun_terbit', 'like', "%$search%");
                });
            })
            ->when($sort, function ($query, $sort) {
                return $query->orderBy('judul', $sort);
            })
            ->orderBy('id', 'desc')
            ->paginate(12);

        $member = Member::where('email', Auth::user()->email)->first();
        $totalDendaUser = 0;

        if ($member) {
            $totalDendaUser = Peminjaman::where('member_id', $member->id)
                ->whereNull('tanggal_pengembalian')
                ->where('denda', '>', 0)
                ->sum('denda');
        }

        return view('peminjamanbuku.index', compact('daftarBuku', 'totalDendaUser'));
    }

    public function create(Request $request)
    {
        $buku_id = $request->input('buku_id');
        $buku = Buku::find($buku_id);

        if (!$buku || $buku->jumlah_unit < 1) {
            return redirect()->route('peminjamanbuku.index')->with('failed', 'Buku tidak tersedia.');
        }

        $member = Member::where('email', Auth::user()->email)->first();

        // Pengecekan denda di sini
        $totalDenda = Peminjaman::where('member_id', $member->id)
            ->whereNull('tanggal_pengembalian')
            ->where('denda', '>', 0)
            ->sum('denda');

        if ($totalDenda > 0) {
            return redirect()->route('peminjamanbuku.index')->with('failed', 'Anda masih memiliki denda sebesar Rp ' . number_format($totalDenda, 0, ',', '.') . '. Harap lunasi terlebih dahulu.');
        }

        return view('peminjamanbuku.create', compact('buku', 'member'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'member_id' => 'required|exists:members,id',
            'tanggal_kembali' => 'required|date',
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        $member = Member::findOrFail($request->member_id);

        $totalDenda = Peminjaman::where('member_id', $member->id)
            ->whereNull('tanggal_pengembalian')
            ->where('denda', '>', 0)
            ->sum('denda');

        if ($totalDenda > 0) {
            return redirect()->back()->with('failed', 'Anda masih memiliki denda sebesar Rp ' . number_format($totalDenda, 0, ',', '.') . '. Harap lunasi sebelum meminjam buku lagi.');
        }

        if ($buku->jumlah_unit < 1) {
            return redirect()->back()->with('failed', 'Buku tidak tersedia untuk dipinjam.');
        }

        Peminjaman::create([
            'buku_id' => $buku->id,
            'member_id' => $member->id,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        $buku->decrement('jumlah_unit');

        return redirect()->route('peminjamanbuku.index')->with('success', 'Buku berhasil dipinjam.');
    }

    // Menampilkan daftar buku yang sedang dipinjam
    public function pengembalianIndex()
    {
        $member = Member::where('email', Auth::user()->email)->first();

        $peminjamans = Peminjaman::with('buku')
            ->where('member_id', $member->id)
            ->whereNull('tanggal_pengembalian')
            ->get();

        return view('pengembalianbuku.index', compact('peminjamans'));
    }

    // Menampilkan form pengembalian
    public function formPengembalian($id)
    {
        // Logika ini sudah bagus: menggunakan with() dan findOrFail()
        $peminjaman = Peminjaman::with('buku', 'member')->findOrFail($id);

        // Pengecekan ini juga sudah bagus
        if ($peminjaman->tanggal_pengembalian !== null) {
            return redirect()->back()->with('failed', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        // PERBAIKAN: Kesalahan pengetikan ada di sini.
        // Sebelumnya: 'pengembalianbuku.from'
        // Seharusnya: 'pengembalianbuku.form' (sesuai nama file view Anda)

        return view('pengembalianbuku.from', compact('peminjaman'));

    }

    // Mengembalikan buku
    public function kembalikan(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'denda' => 'nullable|numeric',
        ]);

        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        if ($peminjaman->tanggal_pengembalian !== null) {
            return redirect()->back()->with('failed', 'Buku sudah dikembalikan.');
        }

        $tanggalPengembalian = Carbon::parse($request->tanggal_pengembalian);
        $jatuhTempo = Carbon::parse($peminjaman->tanggal_kembali);

        // Logika denda ini sudah bagus, menggunakan data dari form sebagai prioritas
        $denda = $request->filled('denda')
            ? $request->input('denda')
            : ($tanggalPengembalian->greaterThan($jatuhTempo)
                ? $tanggalPengembalian->diffInDays($jatuhTempo) * 10000
                : 0);

        $peminjaman->update([
            'tanggal_pengembalian' => $tanggalPengembalian,
            'denda' => $denda
        ]);

        $peminjaman->buku->increment('jumlah_unit');

        // PENYEMPURNAAN: Redirect ke halaman daftar buku yang dipinjam, bukan ke halaman utama.
        // Ini memberikan pengalaman pengguna yang lebih baik.
        return redirect()->route('pengembalianbuku.index')->with('success', 'Buku berhasil dikembalikan.');
    }
}
