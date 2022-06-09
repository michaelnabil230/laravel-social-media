<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\CommunityPostController;

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

Route::get('/', HomeController::class)->name('home');

Auth::routes(['verify' => true]);

Route::get('c/{community}', [CommunityController::class, 'show'])->name('communities.show');

Route::get('p/{post}', [CommunityPostController::class, 'show'])->name('communities.posts.show');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('communities', CommunityController::class)->except('show');
    Route::resource('communities.posts', CommunityPostController::class)->except('show');
    Route::post('posts/{post}/comments', PostCommentController::class)->name('posts.comments.store');
    Route::post('posts/{post}/report', [CommunityPostController::class, 'report'])->name('post.report');
});
