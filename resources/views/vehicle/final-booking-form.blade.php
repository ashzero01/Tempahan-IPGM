<!DOCTYPE html>
<html>
<head>
    <title>Final Booking Details</title>
</head>
<body>
    <h1>Complete Booking for {{ $vehicle->name }}</h1>
    <form action="{{ route('vehicles.booking.store', $vehicle->id) }}" method="POST">
        @csrf
        <input type="hidden" name="departure_date" value="{{ $departureDate }}">
        <input type="hidden" name="return_date" value="{{ $returnDate }}">

        <label for="departure_time">Departure Time:</label>
        <input type="time" id="departure_time" name="departure_time" required>
        <br>
        <label for="return_time">Return Time:</label>
        <input type="time" id="return_time" name="return_time" required>
        <br>
        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required>
        <br>
        <label for="purpose">Purpose:</label>
        <input type="text" id="purpose" name="purpose" required>
        <br>
        <button type="submit">Confirm Booking</button>
    </form>
</body>
</html>
