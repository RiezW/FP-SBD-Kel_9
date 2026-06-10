<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
    protected $table = 'riwayat_aktivitas';
    protected $primaryKey = 'id_aktivitas';
    public $timestamps = false;
}