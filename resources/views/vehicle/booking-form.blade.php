<!DOCTYPE html>
<html>
<head>
    <title>Sistem Tempahan IPGM</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">


    <!-- flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container {
            margin-top: 2rem;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .input-container {
            position: relative;
            width: 100%;
            margin-bottom: 1rem;
        }

        .input-container input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            padding-left: 2.5rem; /* Add padding to accommodate icon */
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            box-sizing: border-box;
            font-size: 1.125rem; /* Increase text size */
            text-align: center; /* Horizontally center the text */
            line-height: 1.5; /* Adjust line height for vertical alignment */
        }

        .input-container .icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #4a90e2;
        }

        .input-container .icon-calendar {
            font-size: 1.25rem; /* Adjust icon size */
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #357bd8;
        }

        .flatpickr-calendar {
            left: 50% !important;
            transform: translateX(-50%) !important;
        }

        .flatpickr-input {
            text-align: center;
        }

        /* Error Message Styles */
        .error-message {
            color: #d9534f; /* Bootstrap red color */
            background-color: #f2dede; /* Light red background */
            border: 1px solid #d9534f; /* Red border */
            padding: 10px;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .error-message ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .error-message ul li {
            margin-bottom: 5px;
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
    <a href="{{ route('vehicles.book') }}">Senarai Kenderaan</a>
    <span>&gt;</span>
    <a href="#" class="active">Pilih Tarikh</a>
</div>

    <!-- Main Content Section -->
    <div class="main-container">
    @if (session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
@endif
@if ($errors->any())
    <div class="error-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="form-container">
            <h1>Pilih Tarikh untuk {{ $vehicle->name }}</h1>
         
            <form action="{{ route('vehicles.check.availability', $vehicle->id) }}" method="POST">
                @csrf
                <label for="departure_date">Tarikh Pergi:</label>
                <!-- Display Validation Errors -->
                <div class="input-container">
                    <i class="icon icon-calendar fas fa-calendar-alt"></i>
                    <input type="text" id="departure_date" name="departure_date" required placeholder="Pilih Tarikh">
                </div>
                <br>
                <label for="return_date">Tarikh Balik:</label>
                <div class="input-container">
                    <i class="icon icon-calendar fas fa-calendar-alt"></i>
                    <input type="text" id="return_date" name="return_date" required placeholder="Pilih Tarikh">
                </div>
                <br>
                <button type="submit">Seterusnya</button>
            </form>
        </div>
    </div>

    <!-- flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr.localize({
                weekdays: {
                    shorthand: ['Ahad', 'Isn', 'Sel', 'Rab', 'Kha', 'Jum', 'Sab'],
                    longhand: ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis'],
                    longhand: ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember']
                }
            });

            flatpickr("#departure_date", {
                dateFormat: "d-m-Y",
                minDate: "today",
            });

            flatpickr("#return_date", {
                dateFormat: "d-m-Y",
                minDate: "today"
            });
        });
    </script>
    
</body>
</html>
        