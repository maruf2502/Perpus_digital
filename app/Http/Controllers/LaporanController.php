<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Member;
use App\Models\Peminjaman;
use Carbon\Carbon;

class LaporanController extends Controller
{


    public function index(Request $request)
    {

        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);


        $namaBulan = Carbon::createFromDate($tahun, $bulan)->translatedFormat('F');

        $totalBuku = Buku::count();
        $totalAnggota = Member::count();
        $anggotaMeminjam = Peminjaman::whereNull('tanggal_pengembalian')
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->distinct('member_id')->count('member_id');
        $bukuDipinjam = Peminjaman::whereNull('tanggal_pengembalian')
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)->count();


        $peminjamanAktif = Peminjaman::with('buku', 'member')
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->orderBy('tanggal_pinjam', 'desc')->get();
        $anggotaAktifIds = $peminjamanAktif->pluck('member_id')->unique();
        $anggotaAktif = Member::whereIn('id', $anggotaAktifIds)->orderBy('nama', 'asc')->get();
        $anggotaTidakAktif = Member::whereNotIn('id', $anggotaAktifIds)->orderBy('nama', 'asc')->get();
        $anggotaDenganDenda = Member::whereHas('peminjamans', function ($query) use ($bulan, $tahun) {
            $query->where('denda', '>', 0)
                ->whereMonth('tanggal_pinjam', $bulan)
                ->whereYear('tanggal_pinjam', $tahun);
        })
            ->withSum(['peminjamans as total_denda' => function ($query) use ($bulan, $tahun) {
                $query->where('denda', '>', 0)
                    ->whereMonth('tanggal_pinjam', $bulan)
                    ->whereYear('tanggal_pinjam', $tahun);
            }], 'denda')
            ->get();
        $semuaBuku = Buku::orderBy('judul', 'asc')->get();

        return view('admin.laporan.index', compact(
            'bulan',
            'tahun',
            'namaBulan',
            'totalBuku',
            'totalAnggota',
            'anggotaMeminjam',
            'bukuDipinjam',
            'semuaBuku',
            'peminjamanAktif',
            'anggotaAktif',
            'anggotaTidakAktif',
            'anggotaDenganDenda'
        ));
    }

    public function cetak(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $data = $this->getLaporanData($bulan, $tahun);

        // Tambahkan nama bulan untuk judul cetak
        $data['namaBulan'] = Carbon::createFromDate($tahun, $bulan)->translatedFormat('F');

        return view('admin.laporan.cetak', $data);
    }

    /**
     * Fungsi pribadi untuk mengambil semua data laporan.
     * Refactored untuk menghindari duplikasi kode.
     */
    private function getLaporanData($bulan, $tahun)
    {
        // Data untuk kartu ringkasan
        $totalBuku = Buku::count();
        $totalAnggota = Member::count();
        $anggotaMeminjam = Peminjaman::whereNull('tanggal_pengembalian')
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->distinct('member_id')->count('member_id');
        $bukuDipinjam = Peminjaman::whereNull('tanggal_pengembalian')
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)->count();

        // Data untuk tabel detail
        $peminjamanAktif = Peminjaman::with('buku', 'member')
            ->whereNull('tanggal_pengembalian')
            ->orderBy('tanggal_pinjam', 'desc')->get();
        $anggotaAktifIds = $peminjamanAktif->pluck('member_id')->unique();
        $anggotaAktif = Member::whereIn('id', $anggotaAktifIds)->orderBy('nama', 'asc')->get();
        $anggotaTidakAktif = Member::whereNotIn('id', $anggotaAktifIds)->orderBy('nama', 'asc')->get();

        return [
            'totalBuku' => $totalBuku,
            'totalAnggota' => $totalAnggota,
            'anggotaMeminjam' => $anggotaMeminjam,
            'bukuDipinjam' => $bukuDipinjam,
            'peminjamanAktif' => $peminjamanAktif,
            'anggotaAktif' => $anggotaAktif,
            'anggotaTidakAktif' => $anggotaTidakAktif,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
    }

    // ... (Fungsi denda, formBayarDenda, prosesBayarDenda Anda yang sudah ada)
    public function denda()
    {
        $members = Member::whereHas('peminjamans', function ($query) {
            $query->where('denda', '>', 0);
        })
            ->withSum(['peminjamans as total_denda' => function ($query) {
                $query->where('denda', '>', 0);
            }], 'denda')
            ->get();
        return view('admin.laporan.denda', compact('members'));
    }

    public function formBayarDenda($id)
    {
        $member = Member::with(['peminjamans' => function ($query) {
            $query->where('denda', '>', 0);
        }, 'peminjamans.buku'])->findOrFail($id);
        $totalDenda = $member->peminjamans->sum('denda');
        return view('admin.laporan.form_bayar_denda', compact('member', 'totalDenda'));
    }

    public function prosesBayarDenda(Request $request, $id)
    {
        Peminjaman::where('member_id', $id)
            ->where('denda', '>', 0)
            ->update(['denda' => 0]);
        return redirect()->route('admin.laporan.denda')->with('success', 'Denda berhasil dilunasi.');
    }
}
