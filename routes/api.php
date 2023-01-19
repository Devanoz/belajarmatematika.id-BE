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

        //profile
        Route::post('/profile', [App\Http\Controllers\Api\Teacher\ProfileController::class, 'update'], ['as' => 'teacher']);

        //kelas
        Route::apiResource('/kelas', App\Http\Controllers\Api\Teacher\KelasController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
        
        //topik
        Route::apiResource('/topiks', App\Http\Controllers\Api\Teacher\TopikController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
        Route::get('/topiksWithMateris', [App\Http\Controllers\Api\Teacher\TopikController::class, 'indexWithMateris', ['as' => 'teacher']]);

        //materi
        Route::apiResource('/materis', App\Http\Controllers\Api\Teacher\MateriController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
    
        //video
        Route::apiResource('/videos', App\Http\Controllers\Api\Teacher\VideoController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
    
        //comment
        Route::apiResource('/comments', App\Http\Controllers\Api\Teacher\CommentController::class, ['except' => ['index', 'show', 'create', 'edit'], 'as' => 'teacher']);
        
        //replyComment
        Route::apiResource('/replyComments', App\Http\Controllers\Api\Teacher\ReplyCommentController::class, ['except' => ['index', 'show', 'create', 'edit'], 'as' => 'teacher']);
        
        //challenge
        Route::apiResource('/challenges', App\Http\Controllers\Api\Teacher\ChallengeController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
    
        //question
        Route::apiResource('/questions', App\Http\Controllers\Api\Teacher\QuestionController::class, ['except' => ['create', 'edit'], 'as' => 'teacher']);
    
        //scoreboard
        Route::get('/scoreboards', [App\Http\Controllers\Api\Teacher\ScoreBoardController::class, 'index'], ['as' => 'teacher']);
    
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

        //profile
        Route::post('/profile', [App\Http\Controllers\Api\Student\ProfileController::class, 'update'], ['as' => 'student']);
        
        //kelas    
        Route::get('/kelas', [App\Http\Controllers\Api\Student\KelasController::class, 'index'], ['as' => 'student']);
        
        //topik
        Route::get('/topiks', [App\Http\Controllers\Api\Student\TopikController::class, 'index'], ['as' => 'student']);
        Route::get('/topiksWithMateris', [App\Http\Controllers\Api\Student\TopikController::class, 'indexWithMateris', ['as' => 'student']]);

        //materi 
        Route::apiResource('/materis', App\Http\Controllers\Api\Student\MateriController::class, ['except' => ['store', 'update', 'destroy', 'create', 'edit'],'as' => 'student']);
        
        //video
        Route::apiResource('/videos', App\Http\Controllers\Api\Student\VideoController::class, ['except' => ['store', 'update', 'destroy', 'create', 'edit'], 'as' => 'student']);
        
        //comment
        Route::apiResource('/comments', App\Http\Controllers\Api\Student\CommentController::class, ['except' => ['index', 'show', 'create', 'edit'], 'as' => 'student']);
        
        //replyComment
        Route::apiResource('/replyComments', App\Http\Controllers\Api\Student\ReplyCommentController::class, ['except' => ['index', 'show', 'create', 'edit'], 'as' => 'student']);
        
        //challenge
        Route::apiResource('/challenges', App\Http\Controllers\Api\Student\ChallengeController::class, ['except' => ['store', 'update', 'destroy','create', 'edit'], 'as' => 'student']);
    
        //question
        Route::get('/questions', [App\Http\Controllers\Api\Student\QuestionController::class, 'index'], ['as' => 'student']);
    
        //scoreboard
        Route::get('/scoreboards', [App\Http\Controllers\Api\Student\ScoreBoardController::class, 'index'], ['as' => 'student']);

        //submitChallenge
        Route::post('/submitChallenges', [App\Http\Controllers\Api\Student\StudentChallengeController::class, 'store'], ['as' => 'student']);
    
        //submitAnswer
        Route::post('/submitAnswers', [App\Http\Controllers\Api\Student\StudentAnswerController::class, 'store'], ['as' => 'student']);

    });

});
