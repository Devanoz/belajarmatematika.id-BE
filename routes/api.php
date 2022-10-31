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

        //kelas
        Route::apiResource('/kelas', App\Http\Controllers\Api\Teacher\KelasController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
        
        //topik
        Route::apiResource('/topiks', App\Http\Controllers\Api\Teacher\TopikController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
        
        //materi
        Route::apiResource('/materis', App\Http\Controllers\Api\Teacher\MateriController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
    
        //video
        Route::apiResource('/videos', App\Http\Controllers\Api\Teacher\VideoController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
    
    
    
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
        
        //kelas    
        Route::get('/kelas', [App\Http\Controllers\Api\Student\KelasController::class, 'index'], ['as' => 'student']);
        
        //topik
        Route::get('/topiks', [App\Http\Controllers\Api\Student\TopikController::class, 'index'], ['as' => 'student']);

        //materi 
        Route::get('/materis', [App\Http\Controllers\Api\Student\MateriController::class, 'index'], ['as' => 'student']);
        
        //video
        Route::get('/videos', [App\Http\Controllers\Api\Student\VideoController::class, 'index'], ['as' => 'student']);
    });

});
