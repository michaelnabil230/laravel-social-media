<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\MarkNotificationsController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController as ProfileSettingsController;

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

Route::get('communities', [CommunityController::class, 'index'])->name('communities.index');
Route::get('c/{community}', [CommunityController::class, 'show'])->name('communities.show');
Route::get('p/{post}', [PostController::class, 'show'])->name('posts.show');

// Users
Route::get('u/{user:username?}', ProfileController::class)->name('profile');

Route::middleware(['auth'])->group(function () {

    Route::get('communities/{community}/join', [CommunityController::class, 'join'])->name('communities.join');
    Route::get('communities/{community}/leave', [CommunityController::class, 'leave'])->name('communities.leave');

    Route::middleware('verified')->group(function () {
        Route::resource('communities', CommunityController::class)->except(['show', 'index']);

        Route::post('posts/{post}/report', [PostController::class, 'report'])->name('post.report');
        Route::resource('posts', PostController::class)->except(['show', 'index']);
        Route::resource('posts.comments', PostCommentController::class)->only(['store', 'delete']);


        // Admin
        Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
            Route::controller(UserController::class)->name('users.')->group(function () {
                // Users
                Route::get('users', 'index')->name('index');
                Route::put('users/{username}/ban', 'ban')->name('ban');
                Route::put('users/{username}/unban', 'unban')->name('unban');
                Route::delete('users/{username}', 'delete')->name('delete');
            });
        });
    });

    // Notifications
    Route::view('notifications', 'users.notifications')->name('notifications');
    Route::post('notifications/mark-as-read', MarkNotificationsController::class)->name('notifications.mark-as-read');

    // Settings
    Route::controller(ProfileSettingsController::class)->name('settings.')->group(function () {
        Route::get('settings',  'edit')->name('profile');
        Route::put('settings',  'update')->name('profile.update');
        Route::delete('settings',  'destroy')->name('profile.delete');
    });
    Route::put('settings/password', [PasswordController::class, 'update'])->name('settings.password.update');
});




require __DIR__ . '/auth.php';
