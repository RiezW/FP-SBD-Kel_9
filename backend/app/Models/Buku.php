<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pengarang;
use App\Models\Kategori;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;

    public function pengarang()
    {
        return $this->belongsTo(
            Pengarang::class,
            'id_pengarang',
            'id_pengarang'
        );
    }

    public function kategori()
    {
        return $this->belongsToMany(
            Kategori::class,
            'buku_kategori',
            'id_buku',
            'id_kategori'
        );
    }
}