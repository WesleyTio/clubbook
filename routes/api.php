<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ReservationController;
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

Route::middleware('auth:sanctum')->group(function(){

    Route::post('logout', [UserController::class, 'logout']);
    Route::put('updateUser', [UserController::class, 'update'])->name('api.user.updateUser');
    Route::get('userbooks/{id}',[UserController::class, 'userbooks'])->name('api.books.userbooks');
    Route::get('availableBooks/{id}',[UserController::class, 'availableBooks'])->name('api.books.availableBooks');
    Route::get('userReservations/{id}',[UserController::class, 'userReservations'])->name('api.books.userReservations');
    Route::post('reservation', [UserController::class, 'validateReservation'])->name('api.books.reservation');
});


Route::get('lastadd', [BookController::class, 'lastadd'])->name('api.books.lastadd');
Route::get('searchBook/{search}', [BookController::class, 'searchBook'])->name('api.books.searchBook');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/',[BookController::class, 'index'])->name('api.books');
    Route::get('books',[BookController::class, 'booksName'])->name('api.books.booksName');
    Route::get('reservations/{id}',[BookController::class, 'reservations'])->name('api.books.reservations');
    Route::post('add',[BookController::class, 'add'])->name('api.books.add');
    Route::get('edit/{id}',[BookController::class, 'edit'])->name('api.books.edit');
    Route::put('update/{id}',[BookController::class, 'update'])->name('api.books.update');
    Route::delete('delete/{id}',[BookController::class, 'delete'])->name('api.books.delete');


});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('editReservation/{id}',[ReservationController::class, 'edit'])->name('api.reservations.edit');
    Route::put('updateReservation/{id}',[ReservationController::class, 'update'])->name('api.reservations.update');
    Route::delete('deleteReservation/{id}',[ReservationController::class, 'destroy'])->name('api.reservations.delete');
});




