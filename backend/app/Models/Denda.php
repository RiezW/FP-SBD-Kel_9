<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;

class Denda extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'jumlah_denda',
        'tgl_bayar',
        'status_bayar'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(
            Peminjaman::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }
}