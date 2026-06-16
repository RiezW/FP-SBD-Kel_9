<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Ulasan extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'ulasan';

    protected $fillable = [
        'id_anggota',
        'nama_anggota',
        'id_buku',
        'judul_buku',
        'rating',
        'teks_ulasan',
        'tgl_ulasan',
        'tag'
    ];
}