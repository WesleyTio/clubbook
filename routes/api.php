<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('userbooks/{id}',[UserController::class, 'userbooks'])->name('api.books.userbooks');

Route::get('/lastadd', [BookController::class, 'lastadd'])->name('api.books.lastadd');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/',[BookController::class, 'index'])->name('api.books');
    Route::post('add',[BookController::class, 'add'])->name('api.books.add');
    Route::get('edit/{id}',[BookController::class, 'edit'])->name('api.books.edit');
    Route::post('update/{id}',[BookController::class, 'update'])->name('api.books.update');
    Route::delete('delete/{id}',[BookController::class, 'delete'])->name('api.books.delete');
});




