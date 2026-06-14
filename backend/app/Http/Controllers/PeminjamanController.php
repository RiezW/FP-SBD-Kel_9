<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Denda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        return response()->json(
            Peminjaman::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            Peminjaman::with([
                'anggota',
                'buku',
                'pustakawan',
                'denda'
            ])->findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function denda($id)
    {
        $peminjaman = Peminjaman::with('denda')
            ->findOrFail($id);

        return response()->json(
            $peminjaman->denda,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function store(Request $request)
    {
        $buku = Buku::findOrFail(
            $request->id_buku
        );

        if ($buku->stok <= 0) {
            return response()->json([
                'message' => 'Stok buku habis'
            ], 400);
        }

        $peminjaman = Peminjaman::create([
            'id_anggota' => $request->id_anggota,
            'id_buku' => $request->id_buku,
            'id_petugas' => $request->id_petugas,

            'tgl_pinjam' => Carbon::today(),

            'tgl_kembali_rencana' => Carbon::today()
                ->addDays(7),

            'status' => 'dipinjam'
        ]);

        $buku->decrement('stok');

        return response()->json(
            $peminjaman,
            201,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function kembali($id)
    {
        $peminjaman = Peminjaman::with('buku')
            ->findOrFail($id);

        if ($peminjaman->status != 'dipinjam') {
            return response()->json([
                'message' => 'Buku sudah dikembalikan'
            ], 400);
        }

        $tanggalKembali = Carbon::today();

        $peminjaman->update([
            'tgl_kembali_aktual' => $tanggalKembali
        ]);

        $peminjaman->buku->increment('stok');

        $hariTerlambat = Carbon::parse(
            $peminjaman->tgl_kembali_rencana
        )->diffInDays(
            $tanggalKembali,
            false
        );

        if ($hariTerlambat > 0) {

            $jumlahDenda = $hariTerlambat * 1000;

            Denda::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'jumlah_denda' => $jumlahDenda,
                'status_bayar' => 'belum_bayar'
            ]);

            $peminjaman->update([
                'status' => 'terlambat'
            ]);
        } else {

            $peminjaman->update([
                'status' => 'dikembalikan'
            ]);
        }

        return response()->json(
            $peminjaman->fresh(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}