<!DOCTYPE html>
<html lang="en">
<head>
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
