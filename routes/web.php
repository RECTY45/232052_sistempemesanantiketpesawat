<?php

use App\Http\Controllers\Auth\ActivateAccountController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::prefix('auth')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'Login')->name('AuthLogin')->middleware('guest');
        Route::resource('register', RegisterController::class);
        Route::post('login', 'AuthLogin')->name('authenticated');
        Route::post('/logout', 'logout')->name('logout');
    });

    Route::get('/', function () {
        return redirect('auth/login');
    });
});
Route::get('/', function () {
    return redirect('auth/login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    route::get('/', [DashController::class, 'dash'])->name('dash.index');
});

Route::group(['prefix' => 'pengguna', 'middleware' => ['auth']], function () {
    route::get('/', [UserController::class, 'index'])->name('user.index');
    route::get('/create', [UserController::class, 'create'])->name('user.create');
    route::post('/', [UserController::class, 'store'])->name('user.store');
    route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
   route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::get('/activate/{token}', [ActivateAccountController::class, 'activate'])->name('activate.account');
