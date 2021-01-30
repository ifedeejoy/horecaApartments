<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\InhouseController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// if (App::environment('production')) {
//     URL::forceScheme('https');
// }
Route::get('users/{type}', [UserController::class, 'index'])->name('filter-users');
Route::get('rates', [RateController::class, 'index'])->name('api-rates');
Route::get('rates/{apartment}', [RateController::class, 'index'])->name('apartment-rates');
Route::get('rate/{rate}', [RateController::class, 'show'])->name('api-rate');
Route::get('guest/{id}', [GuestController::class, 'show'])->name('api-guest');
Route::get('guests', [GuestController::class, 'index'])->name('api-guests');
Route::get('reservations', [ReservationController::class, 'index'])->name('api-reservations');
Route::get('inhouse-guests', [InhouseController::class, 'index'])->name('api-inhouse-guests');
