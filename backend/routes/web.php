<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\PustakawanController;
use App\Http\Controllers\RiwayatAktivitasController;

Route::get('/', function () {
    return view('welcome');
});

/*-----------------------------------------------------------------------
BUKU
-----------------------------------------------------------------------*/

Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/search', [BukuController::class, 'search']);
Route::get('/buku/{id}', [BukuController::class, 'show']);

Route::post('/buku', [BukuController::class, 'store']);
Route::put('/buku/{id}', [BukuController::class, 'update']);
Route::delete('/buku/{id}', [BukuController::class, 'destroy']);

Route::get('/buku/{id}/pengarang', [BukuController::class, 'pengarang']);
Route::get('/buku/{id}/kategori', [BukuController::class, 'kategori']);

/*-----------------------------------------------------------------------
Anggota
-----------------------------------------------------------------------*/

Route::get('/anggota', [AnggotaController::class, 'index']);

Route::get('/anggota/search', [AnggotaController::class, 'search']);

Route::get('/anggota/{id}', [AnggotaController::class, 'show']);

Route::post('/anggota', [AnggotaController::class, 'store']);
Route::put('/anggota/{id}', [AnggotaController::class, 'update']);

Route::put('/anggota/{id}/aktif', [AnggotaController::class, 'aktif']);
Route::put('/anggota/{id}/nonaktif', [AnggotaController::class, 'nonaktif']);

Route::get('/anggota/{id}/peminjaman', [AnggotaController::class, 'peminjaman']);

/*-----------------------------------------------------------------------
Pengarang
-----------------------------------------------------------------------*/

Route::get('/pengarang', [PengarangController::class, 'index']);
Route::get('/pengarang/{id}', [PengarangController::class, 'show']);

/*-----------------------------------------------------------------------
Kategori
-----------------------------------------------------------------------*/

Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/{id}', [KategoriController::class, 'show']);

/*-----------------------------------------------------------------------
Peminjaman
-----------------------------------------------------------------------*/

Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);

Route::get('/peminjaman/{id}/denda', [PeminjamanController::class, 'denda']);

Route::post('/peminjaman', [PeminjamanController::class, 'store']);

Route::put('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali']);

/*-----------------------------------------------------------------------
Denda
-----------------------------------------------------------------------*/

Route::get('/denda', [DendaController::class, 'index']);
Route::get('/denda/{id}', [DendaController::class, 'show']);
Route::put('/denda/{id}/bayar', [DendaController::class, 'bayar']);

/*-----------------------------------------------------------------------
Pustakawan
-----------------------------------------------------------------------*/

Route::get('/pustakawan', [PustakawanController::class, 'index']);
Route::get('/pustakawan/{id}', [PustakawanController::class, 'show']);

Route::get('/pustakawan/{id}/peminjaman', [PustakawanController::class, 'peminjaman']);

/*-----------------------------------------------------------------------
Riwayat Aktivitas
-----------------------------------------------------------------------*/

Route::get('/riwayat-aktivitas', [RiwayatAktivitasController::class, 'index']);
Route::get('/riwayat-aktivitas/{id}', [RiwayatAktivitasController::class, 'show']);