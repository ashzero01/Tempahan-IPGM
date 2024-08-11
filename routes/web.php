<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleBookingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RoomController;
use App\Models\Vehicle;






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



Route::get('/user/vehicle-bookings', [VehicleBookingController::class, 'index'])->name('vehicle.bookings.index');



// Route to manage vehicle (for the admin panel)
Route::resource('vehicles', VehicleController::class);


// Route to list all vehicles
Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index');

// Route to show the form for creating a new vehicle
Route::get('vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');

// Route to store a new vehicle
Route::post('vehicles', [VehicleController::class, 'store'])->name('vehicles.store');

// Route to show the form for editing a specific vehicle
Route::get('vehicles/{id}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');

// Route to update a specific vehicle
Route::put('vehicles/{id}', [VehicleController::class, 'update'])->name('vehicles.update');

// Route to delete a specific vehicle
Route::delete('vehicles/{id}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');




// Display the form to select date and time
// Search for available vehicles based on the date and time
Route::get('/vehicle/search', [VehicleBookingController::class, 'searchVehicles'])->name('bookings.search');

// Search for available vehicles based on the date and time
Route::post('/vehicle/search', [VehicleBookingController::class, 'searchVehicles'])->name('bookings.search');

Route::get('/vehicle/confirm', [VehicleBookingController::class, 'showConfirmForm'])->name('bookings.confirm');


// Show the form to confirm the booking
Route::post('/vehicle/confirm', [VehicleBookingController::class, 'showConfirmForm'])->name('bookings.confirm');


// Store the confirmed booking
Route::post('/vehicle/store', [VehicleBookingController::class, 'store'])->name('bookings.store');


Route::get('/vehicle/booking', [VehicleBookingController::class, 'showBookingForm'])->name('bookings.booking-form');
Route::post('/vehicle/search', [VehicleBookingController::class, 'searchVehicles'])->name('bookings.search');
Route::get('/vehicle/select', [VehicleBookingController::class, 'showSelectForm'])->name('bookings.select');
Route::post('/vehicle/store', [VehicleBookingController::class, 'store'])->name('bookings.store');

Route::delete('/vehicle/bookings/{booking}', [VehicleBookingController::class, 'delete'])->name('vehicle.bookings.destroy');



