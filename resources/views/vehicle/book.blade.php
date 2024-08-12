<!DOCTYPE html>
<html>
<head>
    <title>Book a Vehicle</title>
</head>
<body>
    <h1>Select a Vehicle</h1>
    <ul>
        @foreach($vehicles as $vehicle)
            <li>
                <a href="{{ route('vehicles.booking.details', $vehicle->id) }}">{{ $vehicle->name }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
