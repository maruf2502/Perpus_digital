@extends('layouts.main')

@include('layouts.header')

@section('main-banner')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="caption header-text">
                    <h6>Welcome In</h6>
                    <h2>LIBRARY!</h2>
                    <p>Daftar Buku</p>
                    <div class="search-input">
                        <form id="search" action="#">
                            <input type="text" placeholder="Type Something" id="searchText" name="searchKeyword" />
                            <button role="button">Search Now</button>
                        </form>
                        <a href="{{ route('admin.bukus.create') }}" class="btn btn-primary mt-3">+ Tambah Buku</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('features')
    <div class="container mt-5 bg-white p-4 rounded shadow-sm">
        <h3 class="mb-3 text-dark">Daftar Buku</h3>

        @if($bukus->count())
            <ul class="list-group">
                @foreach($bukus as $buku)
                    <li class="list-group-item">
                        <strong>{{ $buku->judul }}</strong> oleh {{ $buku->penulis }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">Tidak ada buku yang tersedia.</p>
        @endif
    </div>
@endsection
