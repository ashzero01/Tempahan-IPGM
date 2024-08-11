<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Vehicles</title>
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f4f4f9;
        }

        /* Main Content Styling */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .page-title {
            padding: 1.5rem;
            font-size: 1.5rem; /* Adjust font size */
            color: #333333;
            border-bottom: 2px solid #E5E7EB;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 1.25rem;
            margin: 0;
            color: #333;
        }

        .card-text {
            margin: 5px 0;
            color: #555;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 280px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col-md-4 {
            flex: 1;
            min-width: 280px;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <h2 class="header-title">Sistem Tempahan Bilik dan Kenderaan</h2>
        </div>
        <div class="nav-links">
            <a>{{ auth()->user()->name }}</a>
            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">Log Keluar</button>
            </form>
        </div>
    </header>
    <!-- End of Header Section -->

    <!-- Main Content Section -->
    <div class="main-container">
        <div class="page-title">
            <h1>Select Vehicles</h1>
        </div>
        <div class="container">
            <form action="{{ route('bookings.store') }}" method="POST">
                @csrf
                <div class="form-group">
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
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="departure_date" value="{{ $departure_date }}">
                <input type="hidden" name="departure_time" value="{{ $departure_time }}">
                <input type="hidden" name="return_date" value="{{ $return_date }}">
                <input type="hidden" name="return_time" value="{{ $return_time }}">
                <input type="hidden" name="destination" value="{{ $destination }}">
                <input type="hidden" name="purpose" value="{{ $purpose }}">

                <div class="button-container">
                    <a href="{{ route('bookings.booking-form') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
