<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');

Route::group(['middleware' => ['auth']], function() {
    Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('users')->group(function () {
        Route::name('users.')->group(function () {
            Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\UserController::class, 'getLists'])->name('get-lists');
            Route::post('/create', [App\Http\Controllers\UserController::class, 'create'])->name('create');
        });
    });

    Route::prefix('groups')->group(function () {
        Route::name('groups.')->group(function () {
            Route::get('/', [App\Http\Controllers\GroupController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\GroupController::class, 'getLists'])->name('get-lists');
            Route::post('/create', [App\Http\Controllers\GroupController::class, 'create'])->name('create');
        });
    });
});
