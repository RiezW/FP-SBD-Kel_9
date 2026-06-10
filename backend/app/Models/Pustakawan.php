<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;

class Pustakawan extends Model
{
    protected $table = 'pustakawan';
    protected $primaryKey = 'id_petugas';
    public $timestamps = false;

    public function peminjaman()
    {
        return $this->hasMany(
            Peminjaman::class,
            'id_petugas',
            'id_petugas'
        );
    }
}