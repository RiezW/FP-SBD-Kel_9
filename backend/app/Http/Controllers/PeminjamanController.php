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
            Peminjaman::findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}