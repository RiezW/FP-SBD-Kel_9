<?php

namespace App\Http\Controllers;

use App\Models\Denda;

class DendaController extends Controller
{
    public function index()
    {
        return response()->json(
            Denda::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            Denda::with('peminjaman')
                ->findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function bayar($id)
    {
        $denda = Denda::findOrFail($id);

        $denda->update([
            'status_bayar' => 'lunas',
            'tgl_bayar' => now()
        ]);

        return response()->json(
            $denda,
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}