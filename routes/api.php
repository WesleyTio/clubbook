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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/','API\BookController@index')->name('api.books');
    Route::get('/lastadd','API\BookController@lastadd')->name('api.books.lastadd');
    Route::get('add','API\BookController@add')->name('api.books.add');
    Route::get('edit/{id}','API\BookController@edit')->name('api.books.edit');
    Route::get('update/{id}','API\BookController@update')->name('api.books.update');
    Route::get('delete/{id}','API\BookController@delete')->name('api.books.delete');
});




