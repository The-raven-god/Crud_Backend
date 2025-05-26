<?php

use App\Http\Controllers\AuthorsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authors
Route::get('/authors', [AuthorsController::class, 'index']);
Route::post('/authors/store', [AuthorsController::class, 'store']);
Route::delete('/authors/delete/{id}', [AuthorsController::class, 'destroy']);
Route::get('/authors/{id}', [AuthorsController::class, 'show']);
Route::put('/authors/update/{id}', [AuthorsController::class, 'update']);


//Books 
Route::get('/books', [BooksController::class, 'index']);
Route::post('/books/store', [BooksController::class, 'store']); 
Route::get('/books/{id}', [BooksController::class, 'show']); 
Route::put('/books/{id}', [BooksController::class, 'update']); 
Route::delete('/books/{id}', [BooksController::class, 'destroy']); 
