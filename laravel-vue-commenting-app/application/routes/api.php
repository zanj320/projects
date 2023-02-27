<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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

Route::post('/register', [UserController::class, 'register']); //post
Route::post('/login', [UserController::class, 'login']); //post

Route::post('/getAllComments', [CommentController::class, 'getAllComments']); //post

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/postComment', [CommentController::class, 'postComment']); //post
    Route::get('/getUserComments', [CommentController::class, 'getUserComments']); //get

    Route::delete('/removeSingleComment/{comment}', [CommentController::class, 'removeSingleComment']); //delete
    Route::delete('/removeAllComments', [CommentController::class, 'removeAllComments']); //delete

    Route::post('/loadMoreComments', [CommentController::class, 'loadMoreComments']); //post

    Route::delete('/deleteUser', [UserController::class, 'deleteUser']); //delete
    Route::patch('/editUser', [UserController::class, 'editUser']); //patch
    
    Route::delete('/logout', [UserController::class, 'logout']); //delete
});

