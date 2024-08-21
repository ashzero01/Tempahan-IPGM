<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


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
    // Define the time formatting function
    function formatTime($time) {
        $hour = date('H', strtotime($time));

        if ($hour >= 0 && $hour < 12) {
            return date('h:i', strtotime($time)) . " Pagi";  // Morning
        } elseif ($hour >= 12 && $hour < 18) {
            return date('h:i', strtotime($time)) . " Petang";  // Afternoon
        } else {
            return date('h:i', strtotime($time)) . " Malam";  // Evening/Night
        }
    }

    $sortField = $request->input('sortField', 'date'); // Default to 'date'
    $sortDirection = $request->input('sortDirection', 'asc'); // Default to ascending

    // Check if the authenticated user is an admin
    $isAdmin = auth()->user()->role === 'admin';

    // If the user is an admin, show all bookings, otherwise show bookings for the specified user
    $query = $isAdmin
        ? Booking::orderBy($sortField, $sortDirection) // Admin sees all bookings
        : Booking::where('user_id', $user_id)->orderBy($sortField, $sortDirection); // Regular user sees their own bookings

    $bookings = $query->get();

    // Apply time formatting to bookings
    $bookings = $bookings->map(function ($booking) {
        $booking->formatted_start_time = formatTime($booking->start_time);
        $booking->formatted_end_time = formatTime($booking->end_time);
        return $booking;
    });

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
    ], [
        'date.required' => 'Tarikh perlu dipilih.',
        'date.date' => 'Tarikh perlu dalam format yang betul.',
        'start_time.required' => 'Masa mula perlu diisi.',
        'end_time.required' => 'Masa tamat perlu diisi.',
        'end_time.after' => 'Masa tamat perlu selepas masa mula.',
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
        return redirect()->route('bookings.user', ['user_id' => auth()->id(), 'room' => $room->id])->with('success', 'Tempahan berjaya!');
    }

public function show(Booking $booking)
{

    function DayofDate($date) {
        // Array of days in Malay
        $days = [
            'Sunday' => 'Ahad',
            'Monday' => 'Isnin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Khamis',
            'Friday' => 'Jumaat',
            'Saturday' => 'Sabtu'
        ];

        // Get the day name in English
        $dayName = date('l', strtotime($date));

        // Convert it to Malay, or default to English if not found
        $dayInMalay = $days[$dayName] ?? $dayName;

        // Return only the day in Malay
        return $dayInMalay;
    }

    function formatTime($time) {
        $hour = date('H', strtotime($time));

        if ($hour >= 0 && $hour < 12) {
            return date('h:i', strtotime($time)) . " Pagi";  // Morning
        } elseif ($hour >= 12 && $hour < 18) {
            return date('h:i', strtotime($time)) . " Petang";  // Afternoon
        } else {
            return date('h:i', strtotime($time)) . " Malam";  // Evening/Night
        }
    }
    // Format the booking date
    $dayDate = DayofDate($booking->date);
    $startTime = formatTime($booking->start_time);
    $endTime = formatTime($booking->end_time);

    $room = $booking->room; // Assuming there's a relationship between Booking and Room models
    return view('bookings.view', compact('room', 'booking', 'dayDate', 'startTime', 'endTime'));
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
    return redirect()->route('bookings.user', ['user_id' => $booking->user_id])->with('success', 'Tempahan berjaya diterima!');


}

public function reject(Booking $booking)
{
    $booking->update(['status' => 'Ditolak']);
    return redirect()->route('bookings.user', ['user_id' => $booking->user_id])->with('success', 'Tempahan berjaya ditolak!');


}


public function generatePdf(Booking $booking)
{
    function formatDateWithDay($date) {
        // Array of days in Malay
        $days = [
            'Sunday' => 'Ahad',
            'Monday' => 'Isnin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Khamis',
            'Friday' => 'Jumaat',
            'Saturday' => 'Sabtu'
        ];

        // Get the day name in English
        $dayName = date('l', strtotime($date));

        // Convert it to Malay
        $dayInMalay = $days[$dayName];

        // Format the date as "Day, dd/mm/yyyy"
        return date('d/m/Y', strtotime($date)) . " (" . $dayInMalay . ")";
    }
    function formatTime($time) {
        $hour = date('H', strtotime($time));

        if ($hour >= 0 && $hour < 12) {
            return date('h:i', strtotime($time)) . " Pagi";  // Morning
        } elseif ($hour >= 12 && $hour < 18) {
            return date('h:i', strtotime($time)) . " Petang";  // Afternoon
        } else {
            return date('h:i', strtotime($time)) . " Malam";  // Evening/Night
        }
    }

    // Get the room and user information
    $room = $booking->room;
    $user = $booking->user;

    // Path to the PDF template
    $template = 'Scan.pdf';

    // Coordinates for text fields
    $coordinates = [
        'name' => [85  , 45],
        'ICnumber' => [70, 52],
        'phone_number' => [160, 52],
        'affiliation' => [110, 60],
        'purpose' => [65, 67],
        'room_name' => [125, 60],
        'date' => [72, 137],
        'start_time' => [127, 137],
        'end_time' => [165, 137],
    ];

    if ($room->name === 'Dewan Wawasan') {
        $tickCoordinates = [50, 82]; // Example coordinates for 'test 1'
    } elseif ($room->name === 'Dewan Bakti') {
        $tickCoordinates = [50, 87]; // Example coordinates for 'test 2'
    } elseif ($room->name === 'Dewan Kuliah K39') {
        $tickCoordinates = [50, 92]; // Example coordinates for 'test 3'
    } elseif ($room->name === 'Dewan Gerko') {
        $tickCoordinates = [50, 97]; // Example coordinates for 'test 4'
    } elseif ($room->name === 'Bilik Seminar(DK3') {
        $tickCoordinates = [50, 102]; // Example coordinates for 'test 5'
    } elseif ($room->name === 'Dewan Asrama') {
        $tickCoordinates = [50, 107]; // Example coordinates for 'test 6'
    } elseif ($room->name === 'Dewan KDP') {
        $tickCoordinates = [103, 82]; // Example coordinates for 'test 7'
    } elseif ($room->name === 'Bilik Mesy. Gerakans') {
        $tickCoordinates = [103, 87]; // Example coordinates for 'test 8'
    } elseif ($room->name === 'Bilik Mesy. Gigih') {
        $tickCoordinates = [103, 92]; // Example coordinates for 'test 9'
    } elseif ($room->name === 'Bilik Kuliah Mahpoor Baba') {
        $tickCoordinates = [103, 97]; // Example coordinates for 'test 10'
    } else {
        $tickCoordinates = [103, 102]; // Default coordinates for other rooms
    }

    // Create a new FPDI object
    $pdf = new Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile(public_path("/pdf/{$template}"));
    $templateId = $pdf->importPage(1);
    $pdf->useTemplate($templateId);

    // Set font and color
    $pdf->SetFont('Helvetica','BI');
    $pdf->SetTextColor(0, 0, 0);

    // Add text to the PDF at specified coordinates
    $pdf->SetXY($coordinates['name'][0], $coordinates['name'][1]);
    $pdf->Write(0, $booking->user->name);

    $pdf->SetXY($coordinates['ICnumber'][0], $coordinates['ICnumber'][1]);
    $pdf->Write(0, $booking->user->ICnumber);

    $pdf->SetXY($coordinates['phone_number'][0], $coordinates['phone_number'][1]);
    $pdf->Write(0, $booking->user->phone_number);

    $pdf->SetXY($coordinates['affiliation'][0], $coordinates['affiliation'][1]);
    $pdf->Write(0, $booking->user->affiliation);

    $pdf->SetXY($coordinates['purpose'][0], $coordinates['purpose'][1]);
    $pdf->Write(0, $booking->purpose);

    $pdf->SetXY($tickCoordinates[0], $tickCoordinates[1]);
    $pdf->Write(0, '/');

    $pdf->SetXY($coordinates['date'][0], $coordinates['date'][1]);
    $pdf->Write(0, formatDateWithDay($booking->date));

    $pdf->SetXY($coordinates['start_time'][0], $coordinates['start_time'][1]);
    $pdf->Write(0, formatTime($booking->start_time));

    $pdf->SetXY($coordinates['end_time'][0], $coordinates['end_time'][1]);
    $pdf->Write(0, formatTime($booking->end_time));

    $filename = 'booking_details_' . $booking->id . '.pdf';

    // Output PDF and return it
    $pdfOutput = $pdf->Output('S'); // Save output to string

    return response($pdfOutput, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', "inline; filename=\"{$filename}\"");
}

}
