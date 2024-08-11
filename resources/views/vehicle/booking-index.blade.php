<div class="container">
    <h1>My Vehicle Bookings</h1>

    @if($bookings->isEmpty())
        <p>You have no vehicle bookings.</p>
    @else
        @foreach($bookings as $timestamp => $groupedBookings)
            @php
                // Get the destination of the first booking in the group
                $firstBooking = $groupedBookings->first();
                $destination = $firstBooking->destination;
            @endphp
            <h2>Bookings for {{ $destination }}</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Departure Date</th>
                        <th>Departure Time</th>
                        <th>Return Date</th>
                        <th>Return Time</th>
                        <th>Destination</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupedBookings as $booking)
                        <tr>
                            <td>{{ $booking->vehicle->name }}</td>
                            <td>{{ $booking->departure_date }}</td>
                            <td>{{ $booking->departure_time }}</td>
                            <td>{{ $booking->return_date }}</td>
                            <td>{{ $booking->return_time }}</td>
                            <td>{{ $booking->destination }}</td>
                            <td>{{ $booking->purpose }}</td>
                            <td>{{ $booking->status }}</td>
                            <td>
                                <form action="{{ route('vehicle.bookings.destroy', ['booking' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
</div>
