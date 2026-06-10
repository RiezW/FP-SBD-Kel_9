<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $buku = Buku::create([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'tahun_terbit' => $request->tahun_terbit,
            'penerbit' => $request->penerbit,
            'stok' => $request->stok,
            'id_pengarang' => $request->id_pengarang
        ]);

        return response()->json(
            $buku,
            201,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $buku->update([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'tahun_terbit' => $request->tahun_terbit,
            'penerbit' => $request->penerbit,
            'stok' => $request->stok,
            'id_pengarang' => $request->id_pengarang
        ]);

        return response()->json(
            $buku,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ]);
    }
}