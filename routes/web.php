<?php

use App\Http\Controllers\Auth\ActivateAccountController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AirlineController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\AircraftController;
use App\Http\Controllers\Admin\FlightController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
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

// Admin Routes - only accessible by admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
    // Check if user is admin middleware could be added here
    Route::middleware(['checkAdmin'])->group(function () {
        
        // Airlines Management
        Route::resource('airlines', AirlineController::class);
        
        // Airports Management
        Route::resource('airports', AirportController::class);
        
        // Aircraft Management
        Route::resource('aircraft', AircraftController::class);
        
        // Flights Management
        Route::resource('flights', FlightController::class);
        Route::get('flights/aircraft/{airline}', [FlightController::class, 'getAircraftByAirline'])
            ->name('flights.aircraft-by-airline');
            
        // Bookings Management
        Route::resource('bookings', BookingController::class);
        
        // Payments Management
        Route::resource('payments', PaymentController::class);
        Route::get('payments-export', [PaymentController::class, 'export'])->name('payments.export');
        Route::get('payments-print', [PaymentController::class, 'print'])->name('payments.print');
    });
});

Route::group(['prefix' => 'pengguna', 'middleware' => ['auth']], function () {
    route::get('/', [UserController::class, 'index'])->name('user.index');
    route::get('/create', [UserController::class, 'create'])->name('user.create');
    route::post('/', [UserController::class, 'store'])->name('user.store');
    route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::get('/activate/{token}', [ActivateAccountController::class, 'activate'])->name('activate.account');
