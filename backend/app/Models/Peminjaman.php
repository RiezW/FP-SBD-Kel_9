<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Pustakawan;
use App\Models\Denda;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'id_anggota',
        'id_buku',
        'id_petugas',
        'tgl_pinjam',
        'tgl_kembali_rencana',
        'tgl_kembali_aktual',
        'status'
    ];

    public function anggota()
    {
        return $this->belongsTo(
            Anggota::class,
            'id_anggota',
            'id_anggota'
        );
    }

    public function buku()
    {
        return $this->belongsTo(
            Buku::class,
            'id_buku',
            'id_buku'
        );
    }

    public function denda()
    {
        return $this->hasOne(
            Denda::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }

    public function pustakawan()
    {
        return $this->belongsTo(
            Pustakawan::class,
            'id_petugas',
            'id_petugas'
        );
    }
}