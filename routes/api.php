<?php

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

//group route with prefix "teacher"
Route::prefix('teacher')->group(function () {

    //route login
    Route::post('/login', [App\Http\Controllers\Api\Teacher\LoginController::class, 'index', ['as' => 'teacher']]);

    //group route with middleware "auth:api_teacher"
    Route::group(['middleware' => 'auth:api_teacher'], function() {

        //data teacher
        Route::get('/user', [App\Http\Controllers\Api\Teacher\LoginController::class, 'getUser', ['as' => 'teacher']]);

        //refresh token JWT
        Route::get('/refresh', [App\Http\Controllers\Api\Teacher\LoginController::class, 'refreshToken', ['as' => 'teacher']]);

        //logout
        Route::post('/logout', [App\Http\Controllers\Api\Teacher\LoginController::class, 'logout', ['as' => 'teacher']]);
    
    });

});

//group route with prefix "student"
Route::prefix('student')->group(function () {

    //route register
    Route::post('/register', [App\Http\Controllers\Api\Student\RegisterController::class, 'store'], ['as' => 'student']);

    //route login
    Route::post('/login', [App\Http\Controllers\Api\Student\LoginController::class, 'index'], ['as' => 'student']);

    //group route with middleware "auth:api_student"
    Route::group(['middleware' => 'auth:api_student'], function() {

        //data user
        Route::get('/user', [App\Http\Controllers\Api\Student\LoginController::class, 'getUser'], ['as' => 'student']);

        //refresh token JWT
        Route::get('/refresh', [App\Http\Controllers\Api\Student\LoginController::class, 'refreshToken'], ['as' => 'student']);

        //logout
        Route::post('/logout', [App\Http\Controllers\Api\Student\LoginController::class, 'logout'], ['as' => 'student']);
    });

});
