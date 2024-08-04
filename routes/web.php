<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;


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

Route::get('/bookings/{user_id}', 'App\Http\Controllers\BookingController@userBookings')->name('bookings.user');
Route::get('/bookings/{user_id}/', 'App\Http\Controllers\BookingController@userBookings')->name('bookings.user');

Route::get('rooms/bookings/{booking}/edit','App\Http\Controllers\BookingController@edit')->name('bookings.edit');
Route::put('rooms/bookings/{booking}/','App\Http\Controllers\BookingController@update')->name('bookings.update');



Route::get('/user/login', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard'); // Redirect to a page if user is already logged in
    }

    return view('auth.user-login');
})->name('user.login.form');

// Route to handle the login form submission
Route::post('/user/login', [UserLoginController::class, 'login'])->name('user.login');








Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
});
