<div class="container">
    <h1>Select Vehicles</h1>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <label>Available Vehicles</label>
        <div class="row">
            @foreach($vehicles as $vehicle)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <input type="checkbox" name="vehicle_ids[]" id="vehicle_{{ $vehicle->id }}" value="{{ $vehicle->id }}">
                            <label for="vehicle_{{ $vehicle->id }}" class="d-block">
                                <h5 class="card-title">{{ $vehicle->name }}</h5>
                                <p class="card-text">Registration: {{ $vehicle->registration_number }}</p>
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @error('vehicle_ids')
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
