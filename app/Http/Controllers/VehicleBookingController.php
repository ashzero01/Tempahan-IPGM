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
        // Retrieve bookings for the authenticated user
        $user = Auth::user();
    
        // Group bookings by their creation timestamp
        $bookings = VehicleBooking::where('user_id', $user->id)
            ->get()
            ->groupBy(function($booking) {
                return $booking->created_at->format('Y-m-d H:i:s'); // Group by creation timestamp
            });
    
        return view('vehicle.booking-index', ['bookings' => $bookings]);
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
        // Format departure_date and return_date correctly
        $departure_date = Carbon::createFromFormat('d-m-Y', $request->departure_date)->format('Y-m-d');
        $return_date = $request->return_date 
            ? Carbon::createFromFormat('d-m-Y', $request->return_date)->format('Y-m-d')
            : null;
    
        // Validate the input fields
        $validated = $request->validate([
            'vehicle_ids' => 'required|array', // Ensure vehicle_ids is an array
            'vehicle_ids.*' => 'exists:vehicles,id', // Each value must exist in the vehicles table
            'departure_time' => 'required|date_format:H:i',
            'return_time' => 'nullable|date_format:H:i',
            'destination' => 'required|string',
            'purpose' => 'required|string',
        ]);
    
        // Use formatted dates for saving
        $returnDate = $return_date ?? $departure_date;
    
        // Loop through each selected vehicle and create a booking
        foreach ($validated['vehicle_ids'] as $vehicle_id) {
            VehicleBooking::create([
                'user_id' => auth()->id(),
                'vehicle_id' => $vehicle_id,
                'departure_date' => $departure_date,
                'departure_time' => $validated['departure_time'],
                'return_date' => $returnDate,
                'return_time' => $validated['return_time'] ?? null,
                'destination' => $validated['destination'],
                'purpose' => $validated['purpose'],
                'status' => 'Menunggu Pengesahan', // Default status
            ]);
        }
    
        return redirect()->route('vehicle.bookings.index')->with('success', 'Bookings confirmed successfully!');
    }
    
    

    public function delete($id)
    {
        $booking = VehicleBooking::findOrFail($id); // Use findOrFail to handle cases where the ID does not exist
    
        $booking->delete();
    
        return redirect()->route('vehicle.bookings.index')->with('success', 'Booking deleted successfully!');
    }
    
}

