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

Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/{id}', [BukuController::class, 'show']);
Route::get('/anggota', [AnggotaController::class, 'index']);
Route::get('/anggota/{id}', [AnggotaController::class, 'show']);

Route::get('/pengarang', [PengarangController::class, 'index']);
Route::get('/pengarang/{id}', [PengarangController::class, 'show']);

Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/{id}', [KategoriController::class, 'show']);

Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);

Route::get('/denda', [DendaController::class, 'index']);
Route::get('/denda/{id}', [DendaController::class, 'show']);

Route::get('/pustakawan', [PustakawanController::class, 'index']);
Route::get('/pustakawan/{id}', [PustakawanController::class, 'show']);

Route::get('/riwayat-aktivitas', [RiwayatAktivitasController::class, 'index']);
Route::get('/riwayat-aktivitas/{id}', [RiwayatAktivitasController::class, 'show']);