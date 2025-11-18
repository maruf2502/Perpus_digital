<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class MemberController extends Controller
{
    public function dashboard(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $member = Member::where('email', $user->email)->first();

    if (!$member) {
        return redirect()->route('login')->with('error', 'Data member tidak ditemukan.');
    }

    $totalBuku = Buku::count();

    $bukuDipinjam = Peminjaman::where('member_id', $member->id)
        ->whereNull('tanggal_pengembalian')
        ->count();

    $dendaUser = Peminjaman::where('member_id', $member->id)
        ->where('denda', '>', 0)
        ->sum('denda');
        
    $bukuDipinjamList = Peminjaman::with('buku')
        ->where('member_id', $member->id)
        ->whereNull('tanggal_pengembalian')
        ->get();

    $search = $request->input('search');
    $daftarBuku = Buku::where('status', 'tersedia')
        ->when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%");
        })
        ->paginate(12)
        ->appends(request()->query());

    return view('members.dashboard', compact(
        'totalBuku',
        'bukuDipinjam',
        'dendaUser',
        'bukuDipinjamList',
        'daftarBuku'
    ));
}

    // Menampilkan daftar semua member
    public function index(Request $request)
{
    $search = $request->input('search');
    $sort = $request->input('sort');

    $members = Member::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })
        ->when(in_array($sort, ['asc', 'desc']), function ($query) use ($sort) {
            return $query->orderBy('nama', $sort);
        }, function ($query) {
            return $query->orderBy('id', 'desc');
        })
        ->paginate(10)
        ->appends($request->query());

    return view('members.index', compact('members'));
}
    // Menampilkan form untuk menambah member baru
    public function create()
    {
        $roles = Role::where('guard_name', 'member')->pluck('name');
        return view('members.create', compact('roles'));
    }

    // Menyimpan data member baru ke database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomer_telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:members,email',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['admin', 'member', 'guest'])],
        ]);

        $member = Member::create([
            'nama' => $validatedData['nama'],
            'alamat' => $validatedData['alamat'],
            'nomer_telepon' => $validatedData['nomer_telepon'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $member->assignRole($validatedData['role']);

        return redirect()->route('admin.members.index')->with('success', 'Member berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    // Menyimpan perubahan data member
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomer_telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'password' => 'nullable|string|min:6',
        ]);

        $member->nama = $validatedData['nama'];
        $member->alamat = $validatedData['alamat'];
        $member->nomer_telepon = $validatedData['nomer_telepon'];
        $member->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $member->password = Hash::make($validatedData['password']);
        }

        $member->save();

        return redirect()->route('admin.members.index')->with('success', 'Member berhasil diperbarui.');
    }

    // Menghapus data member
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Member berhasil dihapus.');
    }
}
