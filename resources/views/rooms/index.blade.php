<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Book a Room</title>

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

        .room-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px;
        }

        .room-box {
            width: calc(25%);
            padding: 28px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .room-box:hover {
            transform: translateY(-5px);
        }

        .room-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .room-name {
            font-size: 18px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 10px;
        }

        .room-link {
            display: block;
            color: #4a90e2;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .room-link:hover {
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
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <h2 class="header-title">Sistem Tempahan Bilik</h2>
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
        <a href="#" class="active">Senarai Bilik dan Dewan</a>
    </div>

    <!-- Page Title Section -->
    <div class="main-container">
        <div class="page-title">
            Senarai Bilik dan Dewan
        </div>
        <div class="main-content">
            <div class="filter-buttons">
                <button class="filter-button active" data-type="">Semua Bilik</button>
                <button class="filter-button" data-type="bilik">Bilik</button>
                <button class="filter-button" data-type="dewan">Dewan</button>
            </div>

            <div class="room-container">
                <!-- Room Boxes -->
                @foreach ($rooms as $room)
                    <div class="room-box" data-type="{{ $room->description }}" onclick="window.location='{{ route('bookings.create', $room->id) }}';">
                        <!-- Room Image -->
                        <img src="{{ $room->image ? asset('storage/' . $room->image) : asset('images/default-room.jpg') }}" alt="{{ $room->name }}" class="room-image">
                        <!-- Room Name -->
                        <div class="room-name">{{ $room->name }}</div>
                        <!-- Link to room bookings -->
                        <span class="room-link">Tempah Sekarang</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-button');
            const roomBoxes = document.querySelectorAll('.room-box');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to the clicked button
                    button.classList.add('active');

                    // Filter rooms
                    const selectedType = button.getAttribute('data-type');

                    roomBoxes.forEach(box => {
                        const roomType = box.getAttribute('data-type');

                        if (selectedType === '' || roomType === selectedType) {
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
