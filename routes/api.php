<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('App\\Http\\Controllers')->group(function () {
    /*
     * Заметки
     */
    Route::prefix('notes')->group(function () {
        Route::get('', 'UserNoteController@index');
        Route::get('{id}', 'UserNoteController@show');
        Route::put('{id}', 'UserNoteController@store');
        Route::patch('{id}', 'UserNoteController@update');
        Route::delete('{id}', 'UserNoteController@delete');
    });
});
