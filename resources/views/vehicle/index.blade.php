<div class="container">
        <h1>Vehicle List</h1>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Add New Vehicle</a>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Registration Number</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->name }}</td>
                        <td>{{ $vehicle->registration_number }}</td>
                        <td>{{ $vehicle->type }}</td>
                        <td>{{ $vehicle->status }}</td>
                        <td>{{ $vehicle->description }}</td>
                        <td>
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>