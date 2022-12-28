<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

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

Route::prefix('auth')->name('auth.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'index'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login');

        Route::get('register', [RegisterController::class, 'index'])->name('register');
        Route::post('register', [RegisterController::class, 'register'])->name('register');
        /*Route::get('forgot', Forgot::class)->name('forgot');*/
    });

    Route::get('logout', function () {
        Auth::logout();
        return redirect()->route('auth.login');
    })->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::resource('cerita', PostController::class)
        ->except(['index', 'show'])
        ->parameter('cerita', 'post:slug');

    Route::post('cerita/{post:slug}/comment', [PostController::class, 'storeComment'])
        ->name('cerita.comment.store');
    Route::delete('cerita/{post:slug}/comment/{comment}', [PostController::class, 'destroyComment'])
        ->name('cerita.comment.destroy');

    Route::get('profile', [ProfileController::class, 'index'])
        ->name('profile.index');
    // route update, put and patch
    Route::match(['put', 'patch'], 'profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::match(['put', 'patch'], 'profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.update-photo');
});

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::get('/cerita', [PostController::class, 'index'])->name('cerita.index');
Route::get('/cerita/{post:slug}', [PostController::class, 'show'])->name('cerita.show');
