<?php

namespace App\Http\Controllers;

use App\Models\Pengarang;

class PengarangController extends Controller
{
    public function index()
    {
        return response()->json(
            Pengarang::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            Pengarang::with('buku')->findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}