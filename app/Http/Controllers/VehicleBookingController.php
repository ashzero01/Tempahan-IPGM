<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VehicleBooking;
use App\Models\Vehicle;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Response;

class VehicleBookingController extends Controller
{
    // Display a list of bookings
    public function index()
    {
        $user = Auth::user();

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

        return view('vehicle.booking-index', ['bookings' => $bookings]);
    }

    // Show detailed information of a grouped booking
    public function showGroupedBooking($timestamp, $destination)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $bookings = VehicleBooking::where('destination', $destination)
                ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
                ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString())
                ->get();
        } else {
            $bookings = VehicleBooking::where('user_id', $user->id)
                ->where('destination', $destination)
                ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
                ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString())
                ->get();
        }

        return view('vehicle.booking-details', compact('bookings', 'timestamp', 'destination'));
    }

    // Delete a single booking
    public function delete($id)
    {
        $booking = VehicleBooking::findOrFail($id);

        $booking->delete();

        return redirect()->route('vehicle.bookings.index')->with('success', 'Booking deleted successfully!');
    }

    // Delete all bookings in a group
    public function deleteGroupedBookings($timestamp, $destination)
    {
        $user = Auth::user();

        $query = VehicleBooking::where('destination', $destination)
            ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
            ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString());

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $query->delete();

        return redirect()->route('vehicle.bookings.index')->with('success', 'Selected bookings have been deleted successfully!');
    }

    // Approve all bookings in a group
    public function approveGroupedBookings($timestamp, $destination)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect()->route('vehicle.bookings.index')->with('error', 'Unauthorized access.');
        }

        $query = $this->getGroupedBookingQuery($timestamp, $destination);
        $query->update(['status' => 'Diterima']);

        return redirect()->route('vehicle.bookings.index')->with('success', 'Selected bookings have been approved!');
    }

    // Reject all bookings in a group
    public function rejectGroupedBookings($timestamp, $destination)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect()->route('vehicle.bookings.index')->with('error', 'Unauthorized access.');
        }

        $query = $this->getGroupedBookingQuery($timestamp, $destination);
        $query->update(['status' => 'Ditolak']);

        return redirect()->route('vehicle.bookings.index')->with('success', 'Selected bookings have been rejected!');
    }

    // Show the booking form for a specific vehicle
    public function createBooking(Vehicle $vehicle)
    {
        return view('vehicle.booking-form', compact('vehicle'));
    }

    // Check availability of a vehicle for the selected dates
    public function checkAvailability(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:departure_date',
        ], [
            'departure_date.required' => 'Tarikh Pergi diperlukan.',
            'departure_date.date' => 'Tarikh Pergi mesti dalam format tarikh yang sah.',
            'return_date.date' => 'Tarikh Pulang mesti dalam format tarikh yang sah.',
            'return_date.after_or_equal' => 'Tarikh Pulang mesti selepas atau sama dengan Tarikh Bertolak.',
        ]);

        // Convert dates to YYYY-MM-DD format
        $departureDate = Carbon::createFromFormat('d-m-Y', $request->departure_date)->format('Y-m-d');
        $returnDate = $request->return_date ? Carbon::createFromFormat('d-m-Y', $request->return_date)->format('Y-m-d') : $departureDate;

        $availability = $this->checkVehicleAvailability($vehicle, $departureDate, $returnDate);

        if ($availability) {
            return redirect()->route('vehicles.booking.details.final', [
                'vehicle' => $vehicle->id,
                'departure_date' => $request->departure_date,
                'return_date' => $request->return_date ?? $request->departure_date // Ensure return_date is included in query parameters
            ]);
        } else {
            session()->flash('error', 'Kenderaan tidak tersedia untuk tarikh yang dipilih.');
            return redirect()->back();
        }
    }

    // Check if a vehicle is available for the given date range
    private function checkVehicleAvailability($vehicle, $departureDate, $returnDate)
    {
        return !VehicleBooking::where('vehicle_id', $vehicle->id)
            ->where(function ($query) use ($departureDate, $returnDate) {
                $query->where(function ($query) use ($departureDate, $returnDate) {
                    $query->whereBetween('departure_date', [$departureDate, $returnDate])
                          ->orWhereBetween('return_date', [$departureDate, $returnDate]);
                })
                ->orWhere(function ($query) use ($departureDate, $returnDate) {
                    $query->where('departure_date', '<=', $departureDate)
                          ->where('return_date', '>=', $returnDate);
                });
            })
            ->exists();
    }

    // Show the final booking form
    public function finalBookingForm(Request $request, Vehicle $vehicle)
    {
        $departureDate = $request->query('departure_date');
        $returnDate = $request->query('return_date');
        return view('vehicle.final-booking-form', compact('vehicle', 'departureDate', 'returnDate'));
    }

    // Store a new booking
    public function storeBooking(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'departure_time' => 'required|string',
            'return_time' => 'required|string',
            'destination' => 'required|string',
            'purpose' => 'required|string',
        ]);

        // Convert 12-hour format to 24-hour format for storage
        $departureTime24 = date('H:i', strtotime($request->departure_time));
        $returnTime24 = date('H:i', strtotime($request->return_time));

        // Convert dates to YYYY-MM-DD format
        $departureDate = Carbon::createFromFormat('d-m-Y', $request->departure_date)->format('Y-m-d');
        $returnDate = Carbon::createFromFormat('d-m-Y', $request->return_date)->format('Y-m-d');

            // Custom validation for the time
    if ($departureDate == $returnDate && $departureTime24 > $returnTime24) {
        return redirect()->back()->withErrors(['departure_time' => 'Masa bertolak mesti sebelum masa pulang.']);
    }

        $availability = $this->checkVehicleAvailability($vehicle, $departureDate, $returnDate);


        if (!$availability) {
            return redirect()->back()->withErrors(['error' => 'Vehicle is not available for the selected dates.']);
        }

        VehicleBooking::create([
            'vehicle_id' => $vehicle->id,
            'user_id' => Auth::id(),
            'unit_name' => $request->unit_name,
            'departure_date' => $departureDate,
            'return_date' => $returnDate,
            'departure_time' => $departureTime24,
            'return_time' => $returnTime24,
            'destination' => $request->destination,
            'purpose' => $request->purpose,
            'status' => 'Menunggu Pengesahan'
        ]);

        return redirect()->route('vehicle.bookings.index')->with('success', 'Booking created successfully!');
    }

    private function getGroupedBookingQuery($timestamp, $destination)
    {
        $query = VehicleBooking::where('destination', $destination)
            ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
            ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString());

        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        return $query;
    }

    public function generatePdf($timestamp, $destination)
{
    function formatTime($time)
    {
        $hour = (int)date('H', strtotime($time));
        $minute = date('i', strtotime($time));
    
        if ($hour >= 0 && $hour < 12) {
            $period = 'Pagi';  // Morning
            $hour12 = $hour === 0 ? 12 : $hour;
        } elseif ($hour >= 12 && $hour < 19) {
            $period = 'Petang';  // Afternoon
            $hour12 = $hour === 12 ? 12 : $hour - 12;
        } else {
            $period = 'Malam';  // Night
            $hour12 = $hour === 12 ? 12 : $hour - 12;
        }
    
        return sprintf('%d:%02d %s', $hour12, $minute, $period);
    }

    $bookings = VehicleBooking::where('destination', $destination)
        ->whereDate('created_at', '=', Carbon::parse($timestamp)->toDateString())
        ->whereTime('created_at', '=', Carbon::parse($timestamp)->toTimeString())
        ->get();

    // Paths to the template files
    $templatePath1 = public_path('pdf/kenderaan.pdf');
    $templatePath2 = public_path('pdf/kenderaan2.pdf');
    
    if (!file_exists($templatePath1) || !file_exists($templatePath2)) {
        return response()->json(['error' => 'Template file not found.'], 404);
    }

    // Initialize FPDI
    $pdf = new Fpdi();

    // Import the first page of the first template
    $pdf->setSourceFile($templatePath1);
    $template1 = $pdf->importPage(1);
    $pdf->AddPage();
    $pdf->useTemplate($template1);

    // Define coordinates for the first page
    $coordinates = [
        'unit_name' => [100, 102],
        'affiliation' => [52, 232],
        'departure_date' => [66, 116],
        'return_date' => [134, 116],
        'departure_time' => [66, 126],
        'return_time' => [134, 126],
        'destination' => [100, 137],
        'purpose' => [100, 146],
        'vehicle_type' => [90, 165],
        'vehicle_count' => [175, 165],
        'name'=> [52, 212],
        'ICnumber' => [52, 222],
        'phone_number' => [52, 251],
        'book_date' => [52, 242],
    ];

    // Set font
    $pdf->SetFont('Helvetica', '', 12);

    // Set the content using coordinates for the first page
    $pdf->SetXY($coordinates['unit_name'][0], $coordinates['unit_name'][1]);
    $pdf->Cell(0, 10, $bookings->first()->unit_name);

    $pdf->SetXY($coordinates['destination'][0], $coordinates['destination'][1]);
    $pdf->Cell(0, 10, $destination);

    $pdf->SetXY($coordinates['departure_date'][0], $coordinates['departure_date'][1]);
    $pdf->Cell(0, 10, Carbon::parse($bookings->first()->departure_date)->toDateString());

    $pdf->SetXY($coordinates['return_date'][0], $coordinates['return_date'][1]);
    $pdf->Cell(0, 10, Carbon::parse($bookings->first()->return_date)->toDateString());

    $pdf->SetXY($coordinates['departure_time'][0], $coordinates['departure_time'][1]);
    $pdf->Cell(0, 10, formatTime($bookings->first()->departure_time));

    $pdf->SetXY($coordinates['return_time'][0], $coordinates['return_time'][1]);
    $pdf->Cell(0, 10, formatTime($bookings->first()->return_time));

    $pdf->SetXY($coordinates['purpose'][0], $coordinates['purpose'][1]);
    $pdf->Cell(0, 10, $bookings->first()->purpose);

    $vehicleTypes = $bookings->pluck('vehicle.type')->unique()->implode(', ');
    $pdf->SetXY($coordinates['vehicle_type'][0], $coordinates['vehicle_type'][1]);
    $pdf->Cell(0, 10, $vehicleTypes);

    $vehicleCount = $bookings->count();
    $pdf->SetXY($coordinates['vehicle_count'][0], $coordinates['vehicle_count'][1]);
    $pdf->Cell(0, 10, $vehicleCount);

    $pdf->SetXY($coordinates['name'][0], $coordinates['name'][1]);
    $pdf->Cell(0, 10, $bookings->first()->user->name);

    $pdf->SetXY($coordinates['ICnumber'][0], $coordinates['ICnumber'][1]);
    $pdf->Cell(0, 10, $bookings->first()->user->ICnumber);

    $pdf->SetXY($coordinates['affiliation'][0], $coordinates['affiliation'][1]);
    $pdf->Cell(0, 10, $bookings->first()->user->affiliation);

    $pdf->SetXY($coordinates['book_date'][0], $coordinates['book_date'][1]);
    $pdf->Cell(0, 10, $bookings->first()->created_at->toDateString());

    $pdf->SetXY($coordinates['phone_number'][0], $coordinates['phone_number'][1]);
    $pdf->Cell(0, 10, $bookings->first()->user->phone_number);

    // Add a second page from the second template
    $pdf->AddPage();
    $pdf->setSourceFile($templatePath2);
    $template2 = $pdf->importPage(1);
    $pdf->useTemplate($template2);

    // Define coordinates for the second page
    $secondPageCoordinates = [
        'driver' => [92, 112],
        // Add more coordinates as needed
    ];

    // Set content for the second page using coordinates
    $pdf->SetFont('Helvetica', '', 12);

    $pdf->SetXY($secondPageCoordinates['driver'][0], $secondPageCoordinates['driver'][1]);
    $pdf->Cell(0, 10, $bookings->first()->driver_name);

    // Output the PDF as a download
    return Response::make($pdf->Output('S', 'booking.pdf'), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="booking.pdf"'
    ]);
}


    public function showDriverForm($timestamp, $destination)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect()->route('vehicle.bookings.index')->with('error', 'Unauthorized access.');
        }

        return view('vehicle.assign-driver', compact('timestamp', 'destination'));
    }

    public function assignDriverGrouped(Request $request, $timestamp, $destination)
{
    $user = Auth::user();

    if (!$user->isAdmin()) {
        return redirect()->route('vehicle.bookings.index')->with('error', 'Unauthorized access.');
    }

    $request->validate([
        'driver_name' => 'required|string|max:255',
    ]);

    $query = $this->getGroupedBookingQuery($timestamp, $destination);
    $query->update(['driver_name' => $request->input('driver_name')]);

    return redirect()->route('vehicle.bookings.show', ['timestamp' => $timestamp, 'destination' => $destination])
    ->with('success', 'Driver assigned successfully!');}





    
}
