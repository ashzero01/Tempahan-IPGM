<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VehicleBooking;
use App\Models\Vehicle;
use Carbon\Carbon;

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

        $availability = $this->checkVehicleAvailability($vehicle, $departureDate, $returnDate);

        if (!$availability) {
            return redirect()->back()->withErrors(['error' => 'Vehicle is not available for the selected dates.']);
        }

        VehicleBooking::create([
            'vehicle_id' => $vehicle->id,
            'user_id' => Auth::id(),
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
}
