<div class="container">
    <h1>Select a Vehicle</h1>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <label for="vehicle_id">Available Vehicles</label>
        <select name="vehicle_id" id="vehicle_id" class="form-control" required>
            <option value="">Select a vehicle</option>
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">{{ $vehicle->name }} - {{ $vehicle->registration_number }}</option>
            @endforeach
        </select>
        @error('vehicle_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <!-- Hidden Fields -->
        <input type="hidden" name="departure_date" value="{{ $departure_date }}">
        <input type="hidden" name="departure_time" value="{{ $departure_time }}">
        <input type="hidden" name="return_date" value="{{ $return_date }}">
        <input type="hidden" name="return_time" value="{{ $return_time }}">
        <input type="hidden" name="destination" value="{{ $destination }}">
        <input type="hidden" name="purpose" value="{{ $purpose }}">

        <button type="submit" class="btn btn-success">Confirm Booking</button>
        <a href="{{ route('bookings.booking-form') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
