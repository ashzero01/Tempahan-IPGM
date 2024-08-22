<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Tempahan IPGMKKB</title>
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">
    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.6.0-web/css/all.min.css') }}">
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">


    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f3f4f6;
        }

        .page-title {
            padding: 1.5rem;
            font-size: 2.5rem;
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            text-align: center;
            margin-bottom: 2rem;
        }

        .main-container {
            flex: 1;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-content {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .booking-details {
            margin-bottom: 1.5rem;
        }

        .booking-details p {
            font-size: 1.125rem;
            color: #4b5563;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
        }

        .booking-details p span {
            font-weight: 600;
            color: #1f2937;
            margin-right: 1rem; /* Space between label and data */
        }

        .custom-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #4a90e2;
            color: #ffffff;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .custom-button:hover {
            background-color: #357bd8;
        }

        /* Subtle Animation */
        .main-content {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        <a href="#" class="active">Profil</a>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Main Content -->
        <div class="main-content">
            <h2 class="page-title">Maklumat Pengguna</h2>

            <!-- Booking Details -->
            <div class="booking-details">
                <p><span>Nama Pemohon:</span> {{ $user->name }}</p>
                <p><span>IC Pemohon:</span> {{ $user->ICnumber }}</p>
                <p><span>Nombor Telefon Pemohon:</span> {{ $user->phone_number }}</p>
                <p><span>Jawatan/Jabatan Pemohon:</span> {{ $user->affiliation }}</p>
            </div>

            <a href="{{ route('editprofile') }}" class="custom-button">Kemaskini Profil</a>
        </div>
    </div>
</body>
</html>
