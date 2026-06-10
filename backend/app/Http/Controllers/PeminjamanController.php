<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

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
}