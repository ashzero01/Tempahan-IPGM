<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VehicleBooking;
use App\Models\Vehicle;

class VehicleBookingController extends Controller
{
    public function index()
    {
        // Retrieve bookings for the authenticated user
        $user = Auth::user();
        $bookings = VehicleBooking::where('user_id', $user->id)->get();

        return view('vehicle.booking-index', compact('bookings'));
    }

    // Display the form to select date and time
    public function showBookingForm()
    {
        return view('vehicle.booking-form');
    }

    public function searchVehicles(Request $request)
    {
        $validated = $request->validate([
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'return_date' => 'nullable|date',
            'return_time' => 'nullable|date_format:H:i',
            'destination' => 'required|string',
            'purpose' => 'required|string',
        ]);
    
        $return_date = $validated['return_date'] ?? $validated['departure_date'];
        $return_time = $validated['return_time'] ?? '23:59:59';
    
        $vehicles = Vehicle::whereDoesntHave('bookings', function ($query) use ($validated, $return_date, $return_time) {
            $query->where(function ($q) use ($validated, $return_date, $return_time) {
                // Check if the vehicle is booked during or overlapping with the selected period
                $q->where(function ($query) use ($validated, $return_date, $return_time) {
                    $query->whereDate('departure_date', '<=', $return_date)
                          ->whereTime('departure_time', '<=', $return_time)
                          ->whereDate('return_date', '>=', $validated['departure_date'])
                          ->whereTime('return_time', '>=', $validated['departure_time']);
                })
                ->orWhere(function ($query) use ($validated, $return_date, $return_time) {
                    $query->whereDate('departure_date', '<=', $validated['departure_date'])
                          ->whereTime('departure_time', '<=', $validated['departure_time'])
                          ->whereDate('return_date', '>=', $return_date)
                          ->whereTime('return_time', '>=', $return_time);
                });
            });
        })->get();
    
        return view('vehicle.select-vehicle', array_merge($validated, ['vehicles' => $vehicles]));
    }

    public function showSelectForm(Request $request)
    {
        $validated = $request->validate([
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'return_date' => 'nullable|date',
            'return_time' => 'nullable|date_format:H:i',
            'destination' => 'required|string',
            'purpose' => 'required|string',
        ]);

        return view('vehicle.select-vehicle', $validated);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'return_date' => 'nullable|date',
            'return_time' => 'nullable|date_format:H:i',
            'destination' => 'required|string',
            'purpose' => 'required|string',
        ]);

        $returnDate = $validated['return_date'] ?? $validated['departure_date'];


        VehicleBooking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $validated['vehicle_id'],
            'departure_date' => $validated['departure_date'],
            'departure_time' => $validated['departure_time'],
            'return_date' => $returnDate,
            'return_time' => $validated['return_time'] ?? null,
            'destination' => $validated['destination'],
            'purpose' => $validated['purpose'],
            'status' => 'Menunggu Pengesahan', // Default status
        ]);

        return redirect()->route('vehicle.bookings.index')->with('success', 'Booking confirmed successfully!');
    }

    public function delete($id)
    {
        $booking = VehicleBooking::findOrFail($id); // Use findOrFail to handle cases where the ID does not exist
    
        $booking->delete();
    
        return redirect()->route('vehicle.bookings.index')->with('success', 'Booking deleted successfully!');
    }
    
}

