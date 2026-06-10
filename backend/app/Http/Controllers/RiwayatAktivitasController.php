<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAktivitas;

class RiwayatAktivitasController extends Controller
{
    public function index()
    {
        return response()->json(
            RiwayatAktivitas::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            RiwayatAktivitas::findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}