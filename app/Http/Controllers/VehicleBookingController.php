<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VehicleBooking;
use App\Models\Vehicle;
use Carbon\Carbon;

class VehicleBookingController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Check if the user is an admin
    if ($user->role === 'admin') {
        // Admin can see all bookings
        $bookings = VehicleBooking::all()->groupBy(function($booking) {
            return $booking->created_at->format('Y-m-d H:i:s') . '|' . $booking->destination;
        });
    } else {
        // Regular users see only their own bookings
        $bookings = VehicleBooking::where('user_id', $user->id)
            ->get()
            ->groupBy(function($booking) {
                return $booking->created_at->format('Y-m-d H:i:s') . '|' . $booking->destination;
            });
    }

    // Pass the grouped bookings to the view
    return view('vehicle.booking-index', ['bookings' => $bookings]);
}


public function showGroupedBooking($timestamp, $destination)
{
    $user = Auth::user();

    if ($user->isAdmin()) {
        // Admin can see all bookings
        $bookings = VehicleBooking::where('destination', $destination)
            ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
            ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString())
            ->get();
    } else {
        // Regular user can only see their own bookings
        $bookings = VehicleBooking::where('user_id', $user->id)
            ->where('destination', $destination)
            ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
            ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString())
            ->get();
    }

    // Pass the bookings to the view
    return view('vehicle.booking-details', compact('bookings', 'timestamp', 'destination'));
}



    public function delete($id)
    {
        $booking = VehicleBooking::findOrFail($id); // Use findOrFail to handle cases where the ID does not exist

        $booking->delete();

        return redirect()->route('vehicle.bookings.index')->with('success', 'Booking deleted successfully!');
    }

    public function deleteGroupedBookings($timestamp, $destination)
{
    $user = Auth::user();

    // Determine if the user is an admin or a regular user
    $query = VehicleBooking::where('destination', $destination)
        ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
        ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString());

    // Admin can delete all bookings, regular users can only delete their own
    if (!$user->isAdmin()) {
        $query->where('user_id', $user->id);
    }

    // Execute the deletion
    $query->delete();

    // Redirect back with a success message
    return redirect()->route('vehicle.bookings.index')->with('success', 'Selected bookings have been deleted successfully!');
}

public function approveGroupedBookings($timestamp, $destination)
{
    $user = Auth::user();

    // Check if the user is an admin
    if (!$user->isAdmin()) {
        return redirect()->route('vehicle.bookings.index')->with('error', 'Unauthorized access.');
    }

    // Find the bookings to approve
    $bookings = VehicleBooking::where('destination', $destination)
        ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
        ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString())
        ->update(['status' => 'Diterima']);

    return redirect()->route('vehicle.bookings.index')->with('success', 'Selected bookings have been approved!');
}

public function rejectGroupedBookings($timestamp, $destination)
{
    $user = Auth::user();

    // Check if the user is an admin
    if (!$user->isAdmin()) {
        return redirect()->route('vehicle.bookings.index')->with('error', 'Unauthorized access.');
    }

    // Find the bookings to reject
    $bookings = VehicleBooking::where('destination', $destination)
        ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
        ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString())
        ->update(['status' => 'Ditolak']);

    return redirect()->route('vehicle.bookings.index')->with('success', 'Selected bookings have been rejected!');
}


// VehicleBookingController.php
public function createBooking(Vehicle $vehicle)
{
    return view('vehicle.booking-form', compact('vehicle'));
}

public function checkAvailability(Request $request, Vehicle $vehicle)
{
    $request->validate([
        'departure_date' => 'required|date',
        'return_date' => 'required|date|after_or_equal:departure_date',
    ]);

    $availability = $this->checkVehicleAvailability($vehicle, $request->departure_date, $request->return_date);

    if ($availability) {
        return redirect()->route('vehicles.booking.details.final', [
            'vehicle' => $vehicle->id,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date
        ]);
    } else {
        return redirect()->back()->with('error', 'Vehicle is not available for the selected dates.');
    }
}

private function checkVehicleAvailability($vehicle, $departureDate, $returnDate)
{
    // Implement your logic to check availability
    // For example, check if there are any bookings within the date range
    return !VehicleBooking::where('vehicle_id', $vehicle->id)
        ->where(function ($query) use ($departureDate, $returnDate) {
            $query->whereBetween('departure_date', [$departureDate, $returnDate])
                  ->orWhereBetween('return_date', [$departureDate, $returnDate]);
        })->exists();
}

// VehicleBookingController.php
public function finalBookingForm(Request $request, Vehicle $vehicle)
{
    $departureDate = $request->query('departure_date');
    $returnDate = $request->query('return_date');
    return view('vehicle.final-booking-form', compact('vehicle', 'departureDate', 'returnDate'));
}

public function storeBooking(Request $request, Vehicle $vehicle)
{
    $request->validate([
        'departure_time' => 'required|date_format:H:i',
        'return_time' => 'required|date_format:H:i',
        'destination' => 'required|string',
        'purpose' => 'required|string',
    ]);

    VehicleBooking::create([
        'vehicle_id' => $vehicle->id,
        'user_id' => Auth::id(),
        'departure_date' => $request->departure_date,
        'return_date' => $request->return_date,
        'departure_time' => $request->departure_time,
        'return_time' => $request->return_time,
        'destination' => $request->destination,
        'purpose' => $request->purpose,
        'status' => 'Pending'
    ]);

    return redirect()->route('vehicle.bookings.index')->with('success', 'Booking created successfully!');
}



}
