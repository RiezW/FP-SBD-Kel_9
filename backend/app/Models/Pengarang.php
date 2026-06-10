<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;

class Pengarang extends Model
{
    protected $table = 'pengarang';
    protected $primaryKey = 'id_pengarang';
    public $timestamps = false;

    public function buku()
    {
        return $this->hasMany(
            Buku::class,
            'id_pengarang',
            'id_pengarang'
        );
    }
}