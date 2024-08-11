<div class="container">
    <h1>Confirm Booking</h1>

    <p><strong>Departure Date:</strong> {{ $departure_date }}</p>
    <p><strong>Departure Time:</strong> {{ $departure_time }}</p>
    <p><strong>Return Date:</strong> {{ $return_date ?? 'N/A' }}</p>
    <p><strong>Return Time:</strong> {{ $return_time ?? 'N/A' }}</p>
    <p><strong>Vehicle:</strong> {{ $vehicle->name }} - {{ $vehicle->registration_number }}</p>
    <p><strong>Destination:</strong> {{ $destination }}</p>
    <p><strong>Purpose:</strong> {{ $purpose }}</p>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
        <input type="hidden" name="departure_date" value="{{ $departure_date }}">
        <input type="hidden" name="departure_time" value="{{ $departure_time }}">
        <input type="hidden" name="return_date" value="{{ $return_date }}">
        <input type="hidden" name="return_time" value="{{ $return_time }}">
        <input type="hidden" name="destination" value="{{ $destination }}">
        <input type="hidden" name="purpose" value="{{ $purpose }}">

        <button type="submit" class="btn btn-success">Confirm Booking</button>
    </form>
</div>
