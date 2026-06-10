<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    public function buku()
    {
        return $this->belongsToMany(
            Buku::class,
            'buku_kategori',
            'id_kategori',
            'id_buku'
        );
    }
}