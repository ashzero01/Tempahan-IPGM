<!DOCTYPE html>
<html>
<head>
    <title>Book Vehicle</title>
</head>
<body>
    <h1>Book {{ $vehicle->name }}</h1>
    <form action="{{ route('vehicles.check.availability', $vehicle->id) }}" method="POST">
        @csrf
        <label for="departure_date">Departure Date:</label>
        <input type="date" id="departure_date" name="departure_date" required>
        <br>
        <label for="return_date">Return Date:</label>
        <input type="date" id="return_date" name="return_date" required>
        <br>
        <button type="submit">Check Availability</button>
    </form>
</body>
</html>
