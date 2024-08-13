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
            padding: 1.5rem;
            font-size: 2.5rem;
            color: #333333;
            border-bottom: 2px solid #E5E7EB;
        }

        .main-container {
            flex: 1;
            padding: 2rem;
            background-color: #F9FAFB;
        }

        .main-content {
            position: relative;
            max-width: 800px;
            margin: auto;
            background-color: #FFFFFF;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .booking-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }


        .booking-details p {
            font-size: 1.125rem;
            color: #4B5563;
            margin-bottom: 1rem;
        }

        .booking-details p span {
            font-weight: 600;
            color: #1F2937;
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
                <button type="submit" class="logout-button">
                    Log Keluar
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
        <!-- Page Title -->
        <div class="page-title">
            Maklumat Pengguna
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Booking Details -->
            <div class="booking-details">
                <div>
                    <p><span>Nama Pemohon:</span> {{ $user->name }}</p>
                    <p><span>Email Pemohon:</span> {{ $user->email }}</p>
                    <p><span>IC Pemohon:</span> {{ $user->ICnumber}}</p>
                    <p><span>Nombor Telefon Pemohon:</span> {{ $user->phone_number }}</p>
                    <p><span>Jawatan/Jabatan Pemohon:</span> {{ $user->affiliation }}</p>
                </div>
            </div>

            <a href="{{ route('editprofile') }}" class="custom-button">
                Kemaskini Profil
            </a>

</body>

</html>
