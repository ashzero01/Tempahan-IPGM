<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Book a Vehicle</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .vehicle-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px;
        }

        .vehicle-box {
            width: calc(25%);
            padding: 28px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .vehicle-box:hover {
            transform: translateY(-5px);
        }

        .vehicle-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .vehicle-name {
            font-size: 18px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 10px;
        }

        .vehicle-link {
            display: block;
            color: #4a90e2;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .vehicle-link:hover {
            color: #357bd8;
        }

        .page-title {
            padding: 1rem;
            font-size: 2rem;
            color: #333333;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            background-color: #4a90e2;
            color: white;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #357bd8;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <h2 class="header-title">Sistem Tempahan Kenderaan</h2>
        </div>
        <div class="nav-links">
            <a>{{ auth()->user()->name }}</a>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">
                    Log Keluar
                </button>
            </form>
        </div>
    </header>

    <div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Halaman Utama</a>
    <span>&gt;</span>
    <a href="#" class="active">Senarai Kenderaan</a>
</div>

    <!-- Page Title Section -->
    <div class="main-container">
        <div class="page-title">
            Tempahan Kenderaan
        </div>
        <div class="main-content">
            <div class="vehicle-container">
                <!-- Vehicle Boxes -->
                @foreach ($vehicles as $vehicle)
                    <div class="vehicle-box" onclick="window.location='{{ route('vehicles.booking.details', $vehicle->id) }}';">
                        <!-- Vehicle Image -->
                        <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->name }}" class="vehicle-image">
                        <!-- Vehicle Name -->
                        <div class="vehicle-name">{{ $vehicle->name }}</div>
                        <!-- Link to vehicle bookings -->
                        <span class="vehicle-link">Tempah Sekarang</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
