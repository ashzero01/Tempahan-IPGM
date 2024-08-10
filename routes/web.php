<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;





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
    return view('welcome');
});

Route::resource('rooms', 'App\Http\Controllers\RoomController');
//Route::get('rooms/{room}/bookings', 'App\Http\Controllers\BookingController@index')->name('bookings.index');//
Route::get('rooms/{room}/bookings/create', 'App\Http\Controllers\BookingController@create')->name('bookings.create');
Route::post('rooms/{room}/bookings', 'App\Http\Controllers\BookingController@store')->name('bookings.store');
Route::get('rooms/{room}/bookings/json', 'App\Http\Controllers\BookingController@getBookings')->name('bookings.json');
Route::get('rooms/{room}/bookings/json1', 'App\Http\Controllers\BookingController@getBookingsDetails')->name('bookings.json1');
Route::delete('rooms/{room}/bookings/{booking}/destroy', 'App\Http\Controllers\BookingController@destroy')->name('bookings.destroy');
Route::put('/rooms/{room}', 'RoomController@update')->name('rooms.update');
Route::get('rooms/bookings/{booking}', 'App\Http\Controllers\BookingController@show')->name('bookings.show');
Route::delete('rooms/bookings/{booking}/delete', 'App\Http\Controllers\BookingController@delete')->name('bookings.delete');

Route::get('/bookings/{user_id}', [BookingController::class, 'userBookings'])->name('bookings.user');


Route::get('rooms/bookings/{booking}/edit','App\Http\Controllers\BookingController@edit')->name('bookings.edit');
Route::put('rooms/bookings/{booking}/','App\Http\Controllers\BookingController@update')->name('bookings.update');

Route::put('rooms/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
Route::put('rooms/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');



Route::get('/user/login', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard'); // Redirect to a page if user is already logged in
    }

    return view('auth.user-login');
})->name('user.login.form');

// Route to handle the login form submission
Route::post('/user/login', [UserLoginController::class, 'login'])->name('user.login');


Route::get('register', [UserRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserRegisterController::class, 'register']);






Route::get('/temporary-dashboard', function () {
    return view('dashboard');
})->name('temporary-dashboard');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard2');
    })->name('dashboard');

});


Route::get('/fill-form', [PdfController::class, 'fillForm'])->name('fillForm');

Route::get('/bookings/{booking}/pdf', [BookingController::class, 'generatePdf'])->name('bookings.generatePdf');

Route::get('/showprofile/{user_id}', [UserController::class, 'showProfile'])->name('showprofile');

Route::get('/editprofile', [UserController::class, 'editProfile'])->name('editprofile');
Route::put('/updateprofile', [UserController::class, 'updateProfile'])->name('updateprofile');




