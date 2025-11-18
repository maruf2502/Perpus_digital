<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Member;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $totalBuku = Buku::count();
        $totalAnggota = Member::count();
        $anggotaMeminjam = Peminjaman::whereNull('tanggal_pengembalian')
            ->distinct('member_id')
            ->count('member_id');

        $tahunList = Peminjaman::selectRaw('YEAR(tanggal_pinjam) as tahun')
            ->distinct()
            ->pluck('tahun');

        $peminjamanPerBulan = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', $tahun)
            ->groupByRaw('MONTH(tanggal_pinjam)')
            ->pluck('total', 'bulan')
            ->toArray();

        // Normalize semua bulan agar tidak kosong
        $grafikData = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikData[] = $peminjamanPerBulan[$i] ?? 0;
        }

        // Add this: Get recent borrowing activities
        $aktivitasTerbaru = Peminjaman::with(['member', 'buku'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'anggotaMeminjam',
            'grafikData',
            'tahun',
            'tahunList',
            'aktivitasTerbaru' // Add this line
        ));
    }

    public function daftarPeminjam(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc');

        $peminjamans = \App\Models\Peminjaman::with(['member', 'buku'])
            ->whereNull('tanggal_pengembalian')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('member', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->join('members', 'peminjamans.member_id', '=', 'members.id')
            ->orderBy('members.nama', $sort)
            ->select('peminjamans.*')
            ->get();

        return view('admin.daftar_member_peminjam', compact('peminjamans'));
    }

    /**
     * Menampilkan laporan denda
     */
    public function laporanDenda(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'desc');

        // Query untuk mendapatkan peminjaman yang terlambat
        $query = Peminjaman::with(['member', 'buku'])
            ->whereNull('tanggal_pengembalian')
            ->where('tanggal_kembali', '<', Carbon::now());

        // Filter pencarian jika ada
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($memberQuery) use ($search) {
                    $memberQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('buku', function ($bukuQuery) use ($search) {
                        $bukuQuery->where('judul', 'like', '%' . $search . '%');
                    });
            });
        }

        // Sorting berdasarkan nama member
        $query->join('members', 'peminjamans.member_id', '=', 'members.id')
            ->orderBy('members.nama', $sort)
            ->select('peminjamans.*');

        $peminjamans = $query->get();


        $dendaData = $peminjamans->map(function ($peminjaman) {
            $tanggalKembali = Carbon::parse($peminjaman->tanggal_kembali);
            $hariTerlambat = $tanggalKembali->diffInDays(Carbon::now());
            $dendaPerHari = 10000;
            $totalDenda = $hariTerlambat * $dendaPerHari;

            return [
                'id' => $peminjaman->id,
                'member_nama' => $peminjaman->member->nama,
                'member_email' => $peminjaman->member->email,
                'buku_judul' => $peminjaman->buku->judul,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => $peminjaman->tanggal_kembali,
                'hari_terlambat' => $hariTerlambat,
                'denda_per_hari' => $dendaPerHari,
                'total_denda' => $totalDenda
            ];
        });


        $totalKeseluruhan = $dendaData->sum('total_denda');

        return view('admin.laporan.denda', compact('dendaData', 'totalKeseluruhan', 'search', 'sort'));
    }


    public function laporan()
    {
        return view('admin.laporan.index');
    }
}
