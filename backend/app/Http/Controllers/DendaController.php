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
            Denda::findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}