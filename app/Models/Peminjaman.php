<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'buku_id',
        'member_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_pengembalian',
        'denda',
    ];


    protected $casts = [
        'tanggal_pinjam' => 'date:Y-m-d',
        'tanggal_kembali' => 'date:Y-m-d',
        'tanggal_pengembalian' => 'date:Y-m-d',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
