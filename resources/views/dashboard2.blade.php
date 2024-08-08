<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Tempahan IPGMKKB</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('{{ asset('images/background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh; /* Ensure the body takes up full viewport height */
            display: flex;
            flex-direction: column; /* Stack header and main content vertically */
        }

        

        .main-container {
            flex: 1; /* Take up remaining space */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-content {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
            padding: 20px; /* Adjust padding */
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 1000px; /* Set a maximum width */
            width: 100%; /* Ensure it takes up the full width available */
            box-sizing: border-box; /* Ensure padding and border are included in the width and height */
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 16px; /* More consistent gap */
        }
     

        /* Custom Styling for Square Buttons */
        .custom-button {
            width: 150px; /* Set width */
            height: 150px; /* Set height */
            padding: 10px;
            background-color: #007bff; /* Same color for all buttons */
            text-decoration: none; /* Remove underline */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            text-align: center;
            color: #ffffff; /* White text color */
            font-size: 18px;
        }

        .custom-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }



    </style>

<link href="{{ asset('css/header.css') }}" rel="stylesheet">

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
    <button type="submit" class="logout-button">
        Log Keluar
    </button>
</form>

        </div>
    </header>

    <!-- Main Content Container -->
    <div class="main-container">
        <div class="main-content">
            <!-- Buttons Container -->
            <div class="buttons-container">
                <!-- Tempah Bilik Button -->
                <a href="{{ route('rooms.index') }}" class="custom-button">
                    Tempah Bilik
                </a>
                <!-- Tempah Kenderaan Button -->
                <a href="{{ route('bookings.user', ['user_id' => auth()->id()]) }}" class="custom-button">
                    Tempah Kenderaan (Belum siap)
                </a>
                <a href="{{ route('bookings.user', ['user_id' => auth()->id()]) }}" class="custom-button">
                    Lihat Tempahan Bilik
                </a> 
                <a href="{{ route('bookings.user', ['user_id' => auth()->id()]) }}" class="custom-button">
                    Lihat Tempahan Kenderaan (Belum siap)
                </a> 
                <a href="{{ route('bookings.user', ['user_id' => auth()->id()]) }}" class="custom-button">
                    Kemaskini Profil (Belum siap)
                </a>
            </div>
        </div>
    </div>
</body>
</html>
