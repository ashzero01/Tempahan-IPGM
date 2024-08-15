<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Driver</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">

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
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-container {
            position: relative;
            width: 100%;
            margin-bottom: 1rem;
        }

        .input-container input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            padding-left: 2.5rem;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            box-sizing: border-box;
            font-size: 1.125rem;
            text-align: center;
            line-height: 1.5;
        }

        .input-container .icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #4a90e2;
        }

        .input-container .icon-driver {
            font-size: 1.25rem;
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
            margin-top: 1rem;
        }

        button:hover {
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
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">
                    Log Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Halaman Utama</a>
        <span>&gt;</span>
        <a href="{{ route('vehicle.bookings.index') }}">Senarai Tempahan Kenderaan</a>
        <span>&gt;</span>
        <a href="{{ route('vehicle.bookings.show', ['timestamp' => $timestamp, 'destination' => $destination]) }}" class="active">Butiran Tempahan Kenderaan</a>
        <span>&gt;</span>
        <a href="#" class="active">Tugaskan Pemandu</a>
    </div>

    <!-- Main Content Section -->
    <div class="main-container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="form-container">
            <h1>Tugaskan Pemandu</h1>
            <form action="{{ route('vehicle.bookings.assign.driver', ['timestamp' => $timestamp, 'destination' => $destination]) }}" method="POST">
                @csrf
                <div class="input-container">
                    <i class="icon icon-driver fas fa-user"></i>
                    <input type="text" name="driver_name" id="driver_name" required placeholder="Masukkan Nama Pemandu">
                </div>
                <button type="submit">Tugaskan Pemandu</button>
            </form>
        </div>
    </div>
</body>
</html>
