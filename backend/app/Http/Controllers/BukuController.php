<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        return response()->json(
            Buku::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            Buku::with([
                'pengarang',
                'kategori'
            ])->findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function pengarang($id)
    {
        $buku = Buku::with('pengarang')->findOrFail($id);

        return response()->json(
            $buku->pengarang,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function kategori($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return response()->json(
            $buku->kategori,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}