<?php

namespace App\Http\Controllers;

use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {
        return response()->json(
            Anggota::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            Anggota::with('peminjaman')->findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function peminjaman($id)
    {
        $anggota = Anggota::with('peminjaman')
            ->findOrFail($id);

        return response()->json(
            $anggota->peminjaman,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}