<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        return response()->json(
            Ulasan::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            Ulasan::findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required',
            'nama_anggota' => 'required',
            'id_buku' => 'required',
            'judul_buku' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'teks_ulasan' => 'nullable|string'
        ]);

        $ulasan = Ulasan::create([
            'id_anggota' => $request->id_anggota,
            'nama_anggota' => $request->nama_anggota,
            'id_buku' => $request->id_buku,
            'judul_buku' => $request->judul_buku,
            'rating' => (int) $request->rating,
            'teks_ulasan' => $request->teks_ulasan ?? '-',
            'tgl_ulasan' => now()->toISOString(),
            'tag' => $request->tag ?? []
        ]);

        return response()->json(
            $ulasan,
            201,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function update(Request $request, $id)
    {
        $ulasan = Ulasan::findOrFail($id);

        $ulasan->update([
            'id_anggota' => $request->id_anggota ?? $ulasan->id_anggota,
            'nama_anggota' => $request->nama_anggota ?? $ulasan->nama_anggota,
            'id_buku' => $request->id_buku ?? $ulasan->id_buku,
            'judul_buku' => $request->judul_buku ?? $ulasan->judul_buku,
            'rating' => isset($request->rating) ? (int) $request->rating : $ulasan->rating,
            'teks_ulasan' => $request->teks_ulasan ?? $ulasan->teks_ulasan,
            'tag' => $request->tag ?? $ulasan->tag
        ]);

        return response()->json(
            $ulasan,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->delete();

        return response()->json([
            'message' => 'Ulasan berhasil dihapus'
        ]);
    }
}
