<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Tempahan IPGMKKB</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.6.0-web/css/all.min.css') }}">
    
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
            position: relative; /* Position relative to align the delete button */
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

        .filter-buttons {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        .filter-button {
            background-color: #E5E7EB;
            color: #333333;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
            flex: 0 1 auto; /* Allow buttons to shrink but not grow */
            min-width: 120px; /* Ensure buttons have a minimum width */
        }

        .filter-button.active {
            background-color: #3B82F6;
            color: white;
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

        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #d9534f;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #c9302c;
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
                    <a href="#" class="admin-link"><i class="fas fa-tools"></i> Menu Admin</a>
                    <div class="dropdown-content">
                        <a href="{{route('users.list')}}"><i class="fas fa-users"></i> Senarai Pengguna</a>
                        <a href="{{route('vehicles.book')}}"><i class="fas fa-car"></i> Senarai Kenderaan</a>
                        <a href="{{route('showAddAdminForm')}}"><i class="fas fa-user-plus"></i> Tambah Admin</a>
                        <a href="{{ route('rooms.create') }}"><i class="fas fa-plus-square"></i> Tambah Bilik</a>
                        <a href="{{ route('vehicles.create') }}"><i class="fas fa-truck"></i> Tambah Kenderaan</a>
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

    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Halaman Utama</a>
        <span>&gt;</span>
        <a href="{{ route('vehicle.bookings.index') }}">Senarai Tempahan Kenderaan</a>
        <span>&gt;</span>
        <a href="#" class="active">Senarai Kenderaan</a>
    </div>

    <!-- Page Title Section -->
    <div class="main-container">
        <div class="page-title">
            Tempahan Kenderaan
        </div>
        <div class="main-content">
            <div class="filter-buttons">
                <button class="filter-button active" data-type="">Semua Kenderaan</button>
                <button class="filter-button" data-type="bas">Bas</button>
                <button class="filter-button" data-type="kereta">Kereta</button>
                <button class="filter-button" data-type="van">Van</button>
                <button class="filter-button" data-type="pajero">Pajero</button>
                <button class="filter-button" data-type="mini bus">Bas Mini</button>
            </div>
            <div class="vehicle-container">
    <!-- Vehicle Boxes -->
    @foreach ($vehicles as $vehicle)
        <div class="vehicle-box" data-type="{{ $vehicle->type }}" onclick="window.location='{{ route('vehicles.booking.details', $vehicle->id) }}';">
            <!-- Show delete button only for admin users -->
            @if(auth()->user()->role === 'admin')
                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-button" onclick="return confirm('Adakah anda pasti ingin memadam kenderaan ini?');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            @endif
            <!-- Vehicle Image -->
            <img src="{{ asset(($vehicle->image ? $vehicle->image : 'default-vehicle.jpg')) }}" alt="{{ $vehicle->name }}" class="vehicle-image">
            <!-- Vehicle Name -->
            <div class="vehicle-name">{{ $vehicle->name }}</div>
            <!-- Link to vehicle bookings -->
            <span class="vehicle-link">Tempah Sekarang</span>
        </div>
    @endforeach
</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-button');
            const vehicleBoxes = document.querySelectorAll('.vehicle-box');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to the clicked button
                    button.classList.add('active');

                    // Filter vehicles
                    const selectedType = button.getAttribute('data-type');

                    vehicleBoxes.forEach(box => {
                        const vehicleType = box.getAttribute('data-type');

                        if (selectedType === '' || vehicleType === selectedType) {
                            box.style.display = 'block';
                        } else {
                            box.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>