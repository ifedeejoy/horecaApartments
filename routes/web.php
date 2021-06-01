<?php

use App\Http\Controllers\ApartmentsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InhouseController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleAccountController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;

// if (App::environment('production')) {
//     URL::forceScheme('https');
// }
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
Route::view('index', 'index')->name('index');

// website
Route::get('invoice/{reference}', [ReservationController::class, 'show'])->name('website-receipt');
// Front Desk
Route::get('front-desk/reservations', [ReservationController::class, 'index'])->middleware('auth')->name('reservations');
Route::get('front-desk/new-reservation', [ReservationController::class, 'create'])->middleware('auth')->name('create-reservation');
Route::get('front-desk/new-checkin', [InhouseController::class, 'create'])->middleware('auth')->name('create-checkin');
Route::get('front-desk/invoice/{reference}', [ReservationController::class, 'show'])->middleware('auth')->name('reservation-receipt');
Route::get('print-invoice/{reference}', [ReservationController::class, 'show'])->middleware('auth')->name('print-receipt');
Route::get('front-desk/reservation/{id}', [ReservationController::class, 'show'])->middleware('auth')->name('reservation');
Route::get('front-desk/inhouse-guests', [InhouseController::class, 'index'])->middleware('auth')->name('inhouse-guests');
Route::get('front-desk/folio/{id}', [InhouseController::class, 'show'])->middleware('auth')->name('folio');
Route::get('front-desk/receipt/{id}', [InhouseController::class, 'show'])->middleware('auth')->name('receipt');
Route::get('front-desk/calendar', [CalendarController::class, 'index'])->middleware('auth')->name('calendar');
// Calendar doings
Route::get('front-desk/sync-calendar', [GoogleCalendarController::class, 'store'])->middleware('auth')->name('sync-calendar');
Route::get('front-desk/sync-events', [EventController::class, 'store'])->middleware('auth')->name('sync-events');
Route::get('google/oauth', [GoogleAccountController::class, 'store'])->name('google-oauth');
Route::get('front-desk/events', [EventController::class, 'index'])->name('events');
// Post Requests
Route::post('front-desk/make-reservation', [ReservationController::class, 'store'])->middleware('auth')->name('make-reservation');
Route::post('front-desk/add-guest-bill/{id}', [InhouseController::class, 'addBill'])->middleware('auth')->name('add-guest-bill');
Route::post('front-desk/add-guest-payment/{id}', [InhouseController::class, 'addPayment'])->middleware('auth')->name('add-guest-payment');
Route::post('front-desk/extend-stay/{id}', [InhouseController::class, 'extendStay'])->middleware('auth')->name('extend-stay');
Route::post('front-desk/checkout/{id}', [InhouseController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::post('front-desk/move-apartment/{id}', [InhouseController::class, 'roomMove'])->middleware('auth')->name('move-apartment');
Route::post('front-desk/checkin-guest/{reservation}', [ReservationController::class, 'checkinGuest'])->middleware('auth')->name('checkin-guest');

// front-desk views
Route::view('dashboard', 'front-desk.home')->middleware('auth');
Route::view('home', 'front-desk.home')->middleware('auth');
// PUT Requests
Route::put('checkin-guest/{reservation}', [ReservationController::class, 'checkinGuest'])->middleware('auth')->name('api-checkin');
Route::put('front-desk/edit-guest/{id}', [GuestController::class, 'update'])->middleware('auth')->name('edit-guest');
Route::put('front-desk/edit-reservation/{id}', [ReservationController::class, 'update'])->middleware('auth')->name('edit-reservation');
// Delete Requests
Route::delete('front-desk/delete-reservation/{id}', [ReservationController::class, 'destroy'])->middleware('auth')->name('delete-reservation');

// Admin
Route::get('admin/apartments', [ApartmentsController::class, 'index'])->middleware('auth')->name('apartments');
Route::get('admin/apartment/{id}', [ApartmentsController::class, 'show'])->middleware('auth')->name('apartment');
Route::get('admin/users/{type}', [UserController::class, 'index'])->middleware('auth');
Route::get('admin/user/{id}', [UserController::class, 'show'])->middleware('auth');
Route::get('admin/edit-user/{user}', [UserController::class, 'edit'])->middleware('auth');
Route::get('admin/rates', [RateController::class, 'index'])->middleware('auth')->name('rates');
Route::get('admin/maintenance', [MaintenanceController::class, 'index'])->middleware('auth')->name('maintenance');
Route::get('admin/vendors', [VendorController::class, 'index'])->middleware('auth')->name('vendors');
Route::get('admin/vendors/{type}', [VendorController::class, 'index'])->middleware('auth')->name('filter-vendor');
Route::get('admin/vendor/{vendor}', [VendorController::class, 'show'])->middleware('auth')->name('show-vendor');
// post requests
Route::post('admin/create-apartment', [ApartmentsController::class, 'store'])->middleware('auth')->name('create-apartment');
Route::post('admin/creates-owner', [UserController::class, 'store'])->middleware('auth')->name('creates-owner');
Route::post('admin/creates-rate', [RateController::class, 'store'])->middleware('auth')->name('creates-rate');
Route::post('admin/edit-apartment/{id}', [ApartmentsController::class, 'update'])->middleware('auth')->name('edit-apartment');
Route::post('admin/edit-rate', [RateController::class, 'update'])->middleware('auth')->name('edit-rate');
Route::post('admin/report-issue', [MaintenanceController::class, 'store'])->middleware('auth')->name('report-issue');
Route::post('admin/assign-vendor', [MaintenanceController::class, 'assignVendor'])->middleware('auth')->name('assign-vendor');
Route::post('admin/edit-issue', [MaintenanceController::class, 'edit'])->middleware('auth')->name('edit-issue');
Route::post('admin/update-issue',[MaintenanceController::class, 'update'])->middleware('auth')->name('update-issue');
Route::post('admin/create-vendor', [VendorController::class, 'store'])->middleware('auth')->name('create-vendor');
// Put requests
Route::put('admin/update-user/{id}', [UserController::class, 'update'])->middleware('auth')->name('update-user');
Route::put('admin/change-password/{id}', [UserController::class, 'changePassword'])->middleware('auth')->name('change-password');
// delete requests
Route::delete('admin/apartment/{id}', [ApartmentsController::class, 'destroy'])->middleware('auth')->name('delete-apartment');
Route::delete('admin/user/{id}', [UserController::class, 'destroy'])->middleware('auth')->name('delete-user');
Route::delete('admin/rates/{rate}', [RateController::class, 'destroy'])->middleware('auth')->name('delete-rate');
Route::delete('admin/maintenance/{maintenance}', [MaintenanceController::class, 'destroy'])->middleware('auth')->name('delete-issue');

// admin views

// Auth
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');
