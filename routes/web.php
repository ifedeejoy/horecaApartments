<?php

use App\Http\Controllers\ApartmentsController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\Apartments;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

if (App::environment('production')) {
    URL::forceScheme('https');
}
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
// Home Page
Route::view('/', 'index');

// Front Desk
Route::get('front-desk/reservations', [ReservationController::class, 'index'])->name('reservations');
Route::get('front-desk/new-reservation', [ReservationController::class, 'create'])->name('create-reservation');
Route::get('front-desk/new-checkin', [ReservationController::class, 'create'])->name('create-checkin');
Route::get('front-desk/invoice/{reference}', [ReservationController::class, 'show'])->name('reservation-receipt');
Route::get('print-invoice/{reference}', [ReservationController::class, 'show'])->name('print-receipt');
// Post Requests
Route::post('front-desk/make-reservation', [ReservationController::class, 'store'])->name('make-reservation');
Route::view('front-desk/calendar', 'front-desk.calendar');
Route::view('front-desk/home', 'front-desk.home');
Route::view('front-desk/invoice', 'front-desk.invoice');
Route::view('front-desk/inhouse', 'front-desk.inhouse');
// PUT Requests
Route::put('checkin-guest/{reservation}', [ReservationController::class, 'checkinGuest'])->name('api-checkin');
Route::put('front-desk/checkin-guest/{reservation}', [ReservationController::class, 'checkinGuest'])->name('checkin-guest');

// Admin
Route::get('admin/apartments', [ApartmentsController::class, 'index'])->name('apartments');
Route::get('admin/apartment/{id}', [ApartmentsController::class, 'show'])->name('apartment');
Route::get('admin/agents', [UserController::class, 'index'])->name('agents');
Route::get('admin/owners',  [UserController::class, 'index'])->name('owners');
Route::get('admin/employees',  [UserController::class, 'index'])->name('employees');
Route::get('admin/rates', [RateController::class, 'index'])->name('rates');
// post requests
Route::post('admin/create-apartment', [ApartmentsController::class, 'store'])->name('create-apartment');
Route::post('admin/creates-owner', [UserController::class, 'store'])->name('creates-owner');
Route::post('admin/creates-rate', [RateController::class, 'store'])->name('creates-rate');

Route::post('admin/edit-apartment/{id}', [ApartmentsController::class, 'update'])->name('edit-apartment');
Route::post('admin/edit-rate', [RateController::class, 'update'])->name('edit-rate');
// delete requests
Route::delete('admin/apartment/{id}', [ApartmentsController::class, 'destroy'])->name('delete-apartment');
Route::delete('admin/rates/{rate}', [RateController::class, 'destroy'])->name('delete-rate');

Route::view('admin/maintenance', 'admin.apartments.maintenance');


// Auth
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
