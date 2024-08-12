<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Tempahan Kenderaan</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.6.0-web/css/all.min.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .page-title {
            padding: 1rem;
            font-size: 2rem;
            color: #333333;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 1rem;
        }

        .vehicle-card {
            border: 1px solid #E5E7EB;
            border-radius: 0.375rem;
            padding: 1rem;
            width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
            text-align: center;
            position: relative;
        }

        .vehicle-card:hover {
            transform: translateY(-0.5rem);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .vehicle-card img {
            width: 100%;
            height: auto;
            border-radius: 0.375rem;
        }

        .vehicle-card h3 {
            font-size: 1.25rem;
            color: #333;
            margin: 0.5rem 0;
        }

        .vehicle-card p {
            font-size: 1rem;
            color: #6B7280;
            margin: 0;
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
        <a href="{{ route('showprofile', ['user_id' => auth()->user()->id]) }}" class="profile-link">
            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
        </a>

        <!-- Admin Menu -->
        @if(auth()->user()->role === 'admin')
            <div class="admin-menu">
                <a href="#" class="admin-link"><i class="fas fa-tools"></i> Admin Menu</a>
                <div class="dropdown-content">
                    <a href="#"><i class="fas fa-users"></i> See user list</a>
                    <a href="vehicles"><i class="fas fa-car"></i> See vehicle list</a>
                    <a href="#"><i class="fas fa-user-plus"></i> Add admin</a>
                    <a href="{{ route('rooms.create') }}"><i class="fas fa-plus-square"></i> Add room</a>
                    <a href="{{ route('vehicles.create') }}"><i class="fas fa-truck"></i> Add vehicle</a>
                </div>
            </div>
        @endif

        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="logout-button">
                <i class="fas fa-sign-out-alt"></i> Log Keluar
            </button>
        </form>
    </div>
</header>

<div class="main-container">
        <div class="page-title">
            Senarai Tempahan Kenderaan
        </div>
        <div class="main-content">
            <h1>Available Vehicles</h1>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card-container">
                @foreach($vehicles as $vehicle)
                    <div class="vehicle-card" onclick="selectVehicle('{{ route('vehicles.bookVehicle', ['vehicle_id' => $vehicle->id]) }}')">
                        <img src="{{ asset('images/vehicle-placeholder.png') }}" alt="Vehicle Image">
                        <h3>{{ $vehicle->name }}</h3>
                        <p>Registration: {{ $vehicle->registration_number }}</p>
                        <p>Type: {{ $vehicle->type }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function selectVehicle(url) {
            window.location.href = url;
        }
    </script>
</body>
</html>
