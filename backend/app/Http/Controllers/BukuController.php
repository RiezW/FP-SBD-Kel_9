<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        return Buku::all();
    }
    public function show($id)
    {
        return response()->json(
            Buku::findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}