<!DOCTYPE html>
<html>
<head>
    <title>Booking Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet"></head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <h2 class="header-title">Sistem Tempahan Kenderaan</h2>
        </div>
        <div class="nav-links">
            <a>{{ auth()->user()->name }}</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">
                    Log Keluar
                </button>
            </form>
        </div>
    </header>

    <div class="main-container">
        <h1>Booking Details</h1>
        @if($bookings->isEmpty())
            <p>No bookings found for the selected criteria.</p>
        @else
            <ul>
                @foreach($bookings as $booking)
                    <li>
                        <strong>Booking ID:</strong> {{ $booking->id }}<br>
                        <strong>Vehicle ID:</strong> {{ $booking->vehicle_id }}<br>
                        <strong>Departure Date:</strong> {{ $booking->departure_date }}<br>
                        <strong>Return Date:</strong> {{ $booking->return_date }}<br>
                        <strong>Departure Time:</strong> {{ $booking->departure_time }}<br>
                        <strong>Return Time:</strong> {{ $booking->return_time }}<br>
                        <strong>Destination:</strong> {{ $booking->destination }}<br>
                        <strong>Purpose:</strong> {{ $booking->purpose }}<br>
                        <strong>Status:</strong> {{ $booking->status }}<br>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
