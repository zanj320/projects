<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/post', [App\Http\Controllers\PostController::class, 'insert_new_post']);

Route::post('/delete-post', [App\Http\Controllers\PostController::class, 'delete_post']);

Route::get('/u/{user}', [App\Http\Controllers\ProfileController::class, 'view_profile'])->where('user', '[0-9]+');

Route::get('/edit-data', [App\Http\Controllers\ProfileController::class, 'loadEditDataForm']);
Route::post('/edit-data', [App\Http\Controllers\ProfileController::class, 'editData']);

Route::get('/msg/{user}', [App\Http\Controllers\PrivateMessageController::class, 'loadPrivateMessages'])->where('user', '[0-9]+');

Route::get('/search', [App\Http\Controllers\ProfileController::class, 'showSearchedUsers']);

Route::post('/follow_user', [App\Http\Controllers\ProfileController::class, 'followUser']);
Route::post('/unfollow_user', [App\Http\Controllers\ProfileController::class, 'unfollowUser']);

Route::post('/send_message', [App\Http\Controllers\PrivateMessageController::class, 'sendMessage']);

Route::get('/post', function () { return response(view('redirect.405'),  405); });
Route::get('/delete-post', function() { return response(view('redirect.405'),  405); });

Route::get('/follow_user', function () { return response(view('redirect.405'),  405); });
Route::get('/unfollow_user', function () { return response(view('redirect.405'),  405); });
