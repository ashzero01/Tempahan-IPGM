<div class="container">
        <h1>Add New Vehicle</h1>

        <!-- Display success message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Vehicle creation form -->
        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="registration_number">Registration Number</label>
                <input type="text" name="registration_number" id="registration_number" class="form-control" value="{{ old('registration_number') }}" required>
                @error('registration_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}" required>
                @error('type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" name="status" id="status" class="form-control" value="{{ old('status') }}" required>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add Vehicle</button>
        </form>
    </div>