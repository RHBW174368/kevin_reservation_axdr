<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
	Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
	Route::get('/rooms', [App\Http\Controllers\RoomsController::class, 'index'])->name('rooms.index');
	Route::get('/booking', [App\Http\Controllers\BookingController::class, 'index'])->name('booking.index');
	Route::delete('/booking', [App\Http\Controllers\BookingController::class, 'deleteBooking'])->name('booking.delete');
	Route::post('/booking/validate-booking', [App\Http\Controllers\BookingController::class, 'validateBooking'])->name('booking.validate-booking');
	Route::get('/booking/list', [App\Http\Controllers\BookingController::class, 'getBookings'])->name('booking.list');
	Route::get('/booking/fetch', [App\Http\Controllers\BookingController::class, 'fetchBooking'])->name('booking.fetch');
});
