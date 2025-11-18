@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Laporan Denda Member</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($members->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Member</th>
                    <th>Email</th>
                    <th>Total Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr>
                        <td>{{ $member->nama }}</td>
                        <td>{{ $member->email }}</td>
                        <td>Rp {{ number_format($member->peminjamans->sum('denda'), 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.laporan.bayar_denda', $member->id) }}" class="btn btn-sm btn-success">
                                Bayar Denda
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Tidak ada member yang memiliki denda.</div>
    @endif
</div>
@endsection
