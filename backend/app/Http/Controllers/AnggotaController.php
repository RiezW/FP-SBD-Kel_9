<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $anggota = Anggota::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status' => $request->status
        ]);

        return response()->json(
            $anggota,
            201,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status' => $request->status
        ]);

        return response()->json(
            $anggota,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function search(Request $request)
    {
        $query = Anggota::query();

        if ($request->filled('nama')) {
            $query->where(
                'nama',
                'like',
                '%' . $request->nama . '%'
            );
        }

        if ($request->filled('email')) {
            $query->where(
                'email',
                'like',
                '%' . $request->email . '%'
            );
        }

        if ($request->filled('id_anggota')) {
            $query->where(
                'id_anggota',
                $request->id_anggota
            );
        }

        return response()->json(
            $query->get(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function aktif($id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->update([
            'status' => 'aktif'
        ]);

        return response()->json(
            $anggota,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function nonaktif($id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->update([
            'status' => 'non-aktif'
        ]);

        return response()->json(
            $anggota,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}