<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);