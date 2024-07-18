<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    public function index(Room $room)
    {
        // Fetch all bookings for the specified room
        $bookings = $room->bookings;
    
        
        return view('bookings.index', compact('bookings', 'room'));

    }
    
    
    public function getBookings(Room $room)
    {
        // Fetch all bookings for the specified room
        $bookings = $room->bookings;
    
        return response()->json($bookings);
    }

    public function getBookingsDetails(Request $request, Room $room)
{
    // Validate the date parameter
    $request->validate([
        'date' => 'required|date',
    ]);

    // Fetch bookings for the specified room and date
    $bookings = Booking::where('room_id', $room->id)
                       ->where('date', $request->date)
                       ->get();

    return response()->json($bookings);
}

public function userBookings($user_id)
{
    // Get the authenticated user's ID
$userId = Auth::id();

// Fetch bookings for the authenticated user
$bookings = Booking::where('user_id', $userId)->get();

// Return the view with the bookings data
return view('bookings.user', compact('bookings'));
    
}
    public function create(Room $room)
    {
        return view('bookings.create', compact('room'));
    }


    public function store(Request $request, Room $room)
{
    // Validate the request data
    $request->validate([
        'date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    // Check if there are any existing bookings for the specified room that overlap with the new booking
    $existingBooking = Booking::where('room_id', $room->id)
        ->where('date', $request->date)
        ->where(function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('start_time', '>=', $request->start_time)
                    ->where('start_time', '<', $request->end_time);
            })
            ->orWhere(function ($query) use ($request) {
                $query->where('end_time', '>', $request->start_time)
                    ->where('end_time', '<=', $request->end_time);
            })
            ->orWhere(function ($query) use ($request) {
                $query->where('start_time', '<', $request->start_time)
                    ->where('end_time', '>', $request->end_time);
            });
        })
        ->first();

    // If an existing booking is found, return with an error message
    if ($existingBooking) {
        return redirect()->route('bookings.create', ['room' => $room->id])->with('error', 'This room is already booked for the specified date and time.');
    }

    // Create a new booking
    Booking::create([
        'user_id' => auth()->id(),
        'room_id' => $room->id,
        'date' => $request->date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'purpose' => $request->purpose,

    ]);

    // Redirect to the booking creation page with a success message
    return redirect()->route('bookings.create', ['room' => $room->id])->with('success', 'Booking created successfully!');
}
public function show(Booking $booking)
{
    $room = $booking->room; // Assuming there's a relationship between Booking and Room models
    return view('bookings.view', compact('room', 'booking'));
}


public function delete(Booking $booking)
{
    $user_id = $booking->user_id; // Assuming there's a user_id field in the Booking model
    $booking->delete();
    return redirect()->route('bookings.user', ['user_id' => $user_id])->with('success', 'Booking deleted successfully!');
}

    public function destroy(Room $room, Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.create', ['room' => $room->id])->with('success', 'Booking deleted successfully!');
    }

    public function edit(Booking $booking)
    {
        $room = $booking->room; // Assuming there's a relationship between Booking and Room models
        return view('bookings.edit', compact('room', 'booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        // Validate the request data
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string|max:255',
        ]);

        // Check if there are any existing bookings for the specified room that overlap with the updated booking
        $existingBooking = Booking::where('room_id', $booking->room_id)
            ->where('date', $request->date)
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('start_time', '>=', $request->start_time)
                        ->where('start_time', '<', $request->end_time);
                })
                ->orWhere(function ($query) use ($request) {
                    $query->where('end_time', '>', $request->start_time)
                        ->where('end_time', '<=', $request->end_time);
                })
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_time', '<', $request->start_time)
                        ->where('end_time', '>', $request->end_time);
                });
            })
            ->first();

        // If an existing booking is found, return with an error message
        if ($existingBooking) {
            return redirect()->route('bookings.edit', ['booking' => $booking->id])->with('error', 'This room is already booked for the specified date and time.');
        }

        // Update the booking
        $booking->update([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
        ]);

        // Redirect to the user's bookings page with a success message
        return redirect()->route('bookings.user', ['user_id' => $booking->user_id])->with('success', 'Booking updated successfully!');
    }

    
}
