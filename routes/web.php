<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController; // Import BookController

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', BookController::class);
