<?php

use App\Http\Controllers\ApartmentsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;
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
Route::get('apartment-reservations/{id}', [ApartmentsController::class, 'show'])->name('api-apartment-reservations');
Route::get('user-reservations/{id}', [UserController::class, 'show']);
Route::get('inhouse-guests', [InhouseController::class, 'index'])->name('api-inhouse-guests');
Route::get('calendar', [CalendarController::class, 'index'])->name('api-calendar');
Route::get('events', [EventController::class, 'index'])->name('api-events');
Route::get('apartments', [ApartmentsController::class, 'index'])->name('api-apartments');
Route::get('apartment/{id}', [ApartmentsController::class, 'show'])->name('api-apartment');
Route::post('web-availability', [ReservationController::class, 'webAvailability'])->name('api-web-availability');
Route::post('availability', [ReservationController::class, 'availabilityCheck'])->name('api-availability');
Route::post('create-guest', [GuestController::class, 'store'])->name('api-guest');
Route::post('new-reservation', [ReservationController::class, 'store'])->name('api-new-reservation');