<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Member extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $table = 'members';

    // INI PENTING untuk Spatie Permission
    protected $guard_name = 'member';

    protected $fillable = [
        'nama',
        'alamat',
        'nomer_telepon',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
