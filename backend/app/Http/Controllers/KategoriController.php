<?php

namespace App\Http\Controllers;

use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(
            Kategori::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            Kategori::findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}