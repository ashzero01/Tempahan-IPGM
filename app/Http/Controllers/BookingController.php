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
    // Fetch all bookings of type 'rooms' for the specified room
    $bookings = Booking::where('room_id', $room->id)
                       ->where('type', 'rooms')
                       ->get();

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

public function userBookings($user_id, Request $request)
{
    $sortField = $request->input('sortField', 'date'); // Default to 'date'
    $sortDirection = $request->input('sortDirection', 'asc'); // Default to ascending

    // Check if the authenticated user is an admin
    $isAdmin = auth()->user()->role === 'admin';

    // If the user is an admin, show all bookings, otherwise show bookings for the specified user
    $query = $isAdmin
        ? Booking::orderBy($sortField, $sortDirection) // Admin sees all bookings
        : Booking::where('user_id', $user_id)->orderBy($sortField, $sortDirection); // Regular user sees their own bookings

    $bookings = $query->get();

    return view('bookings.user', compact('bookings', 'sortField', 'sortDirection'));
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
    
        // Check if there are any existing bookings for the specified room that overlap with the new booking, excluding those with status "Ditolak"
        $existingBooking = Booking::where('room_id', $room->id)
            ->where('date', $request->date)
            ->whereIn('status', ['Menunggu Pengesahan', 'Diterima'])
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
            return redirect()->route('bookings.create', ['room' => $room->id])->with('error', 'Bilik ini telah ditempah pada tarikh dan masa yang sama.');
        }
    
        // Create a new booking
        Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $room->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'Menunggu Pengesahan',
            'type' => 'rooms',
        ]);
    
        // Redirect to the booking creation page with a success message
        return redirect()->route('bookings.create', ['room' => $room->id])->with('success', 'Tempahan berjaya!');
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
    return redirect()->route('bookings.user', ['user_id' => $user_id])->with('success', 'Tempahan berjaya dipadam!');
}

    public function destroy(Room $room, Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.create', ['room' => $room->id])->with('success', 'Tempahan berjaya dipadam!');
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
            return redirect()->route('bookings.edit', ['booking' => $booking->id])->with('error', 'Bilik ini telah ditempah pada tarikh dan masa yang sama.');
        }

        // Update the booking
        $booking->update([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'Menunggu Pengesahan',
        ]);

        // Redirect to the user's bookings page with a success message
        return redirect()->route('bookings.user', ['user_id' => $booking->user_id])->with('success', 'Tempahan berjaya dikemaskini!');
    }

    public function approve(Booking $booking)
{
    $booking->update(['status' => 'Diterima']);
    return redirect()->route('bookings.show', ['booking' => $booking->id])->with('success', 'Tempahan berjaya diterima!');

    
}

public function reject(Booking $booking)
{
    $booking->update(['status' => 'Ditolak']);
    return redirect()->route('bookings.show', ['booking' => $booking->id])->with('success', 'Tempahan berjaya ditolak!');

    
}

}
