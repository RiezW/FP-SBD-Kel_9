<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', [BukuController::class, 'index']);
Route::get('/books/{id}', [BukuController::class, 'show']);