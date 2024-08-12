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

// Public Routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    // Authentication Routes
    Route::get('/user/login', function () {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.user-login');
    })->name('user.login.form');
    Route::post('/user/login', [UserLoginController::class, 'login'])->name('user.login');

    Route::get('register', [UserRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [UserRegisterController::class, 'register']);
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', function () {
        return view('dashboard2'); // or another view for authenticated users
    })->name('dashboard');

    // Room Routes
    Route::resource('rooms', RoomController::class);
    Route::get('/rooms/filter/{description}', [RoomController::class, 'filter'])->name('rooms.filter');
    Route::get('rooms/{room}/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('rooms/{room}/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('rooms/{room}/bookings/json', [BookingController::class, 'getBookings'])->name('bookings.json');
    Route::get('rooms/{room}/bookings/json1', [BookingController::class, 'getBookingsDetails'])->name('bookings.json1');
    Route::delete('rooms/{room}/bookings/{booking}/destroy', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::get('rooms/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::delete('rooms/bookings/{booking}/delete', [BookingController::class, 'delete'])->name('bookings.delete');
    Route::get('/bookings/{user_id}', [BookingController::class, 'userBookings'])->name('bookings.user');
    Route::get('rooms/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('rooms/bookings/{booking}/', [BookingController::class, 'update'])->name('bookings.update');
    Route::put('rooms/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    Route::put('rooms/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

    // User Profile Routes
    Route::get('/showprofile/{user_id}', [UserController::class, 'showProfile'])->name('showprofile');
    Route::get('/editprofile', [UserController::class, 'editProfile'])->name('editprofile');
    Route::put('/updateprofile', [UserController::class, 'updateProfile'])->name('updateprofile');

    // Vehicle Booking Routes
    Route::get('/user/vehicle-bookings', [VehicleBookingController::class, 'index'])->name('vehicle.bookings.index');
    Route::get('/user/vehicle-bookings/{timestamp}/{destination}', [VehicleBookingController::class, 'showGroupedBooking'])->name('vehicle.bookings.show');
    Route::post('vehicle/bookings/{timestamp}/{destination}/approve', [VehicleBookingController::class, 'approveGroupedBookings'])->name('vehicle.bookings.approve');
    Route::post('vehicle/bookings/{timestamp}/{destination}/reject', [VehicleBookingController::class, 'rejectGroupedBookings'])->name('vehicle.bookings.reject');
    Route::delete('/vehicle/bookings/{booking}', [VehicleBookingController::class, 'delete'])->name('vehicle.bookings.destroy');
    Route::delete('/user/vehicle-bookings/group/{timestamp}/{destination}', [VehicleBookingController::class, 'deleteGroupedBookings'])->name('vehicle.bookings.delete.group');
    // Web Routes
    Route::get('/vehicles/{vehicle}/book', [VehicleBookingController::class, 'createBooking'])->name('vehicles.booking.details');
    Route::post('/vehicles/{vehicle}/check-availability', [VehicleBookingController::class, 'checkAvailability'])->name('vehicles.check.availability');
    // Web Routes
    Route::get('/vehicles/{vehicle}/book/final', [VehicleBookingController::class, 'finalBookingForm'])->name('vehicles.booking.details.final');
    Route::post('/vehicles/{vehicle}/book/final', [VehicleBookingController::class, 'storeBooking'])->name('vehicles.booking.store');




    // Vehicle Routes

    Route::get('/vehicles/book', [VehicleController::class, 'book'])->name('vehicles.book');
    Route::resource('vehicles', VehicleController::class)->except(['show']);



    // Fill Form and PDF Routes
    Route::get('/fill-form', [PdfController::class, 'fillForm'])->name('fillForm');
    Route::get('/bookings/{booking}/pdf', [BookingController::class, 'generatePdf'])->name('bookings.generatePdf');

});

