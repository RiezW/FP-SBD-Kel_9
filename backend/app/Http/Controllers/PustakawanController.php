<?php

namespace App\Http\Controllers;

use App\Models\Pustakawan;

class PustakawanController extends Controller
{
    public function index()
    {
        return response()->json(
            Pustakawan::all(),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        return response()->json(
            Pustakawan::findOrFail($id),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}