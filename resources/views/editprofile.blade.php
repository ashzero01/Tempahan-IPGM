<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Tempahan IPGMKKB</title>
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">


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

        .profile-form {
            display: flex;
            flex-direction: column;
        }

        .profile-form label {
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #4B5563;
        }

        .profile-form input {
            padding: 0.5rem;
            border: 1px solid #E5E7EB;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .profile-form button {
            padding: 0.75rem 1.5rem;
            background-color: #3B82F6;
            color: white;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .profile-form button:hover {
            background-color: #2563EB;
        }

    </style>

<link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">

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
    <a href="{{ route('showprofile', ['user_id' => auth()->user()->id]) }}">Profil</a>
    <span>&gt;</span>
    <a href="#" class="active">Kemaskini Profil</a>
</div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Page Title -->
        <div class="page-title">
            Kemaskini Profil
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Form -->
            <form action="{{ route('updateprofile') }}" method="POST" class="profile-form">
                @csrf
                @method('PUT')
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>

                <label for="ICnumber">IC:</label>
                <input type="text" id="ICnumber" name="ICnumber" value="{{ old('ICnumber', $user->ICnumber) }}" required>

                <label for="phone_number">Nombor Telefon:</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>

                <label for="affiliation">Jawatan/Jabatan:</label>
                <input type="text" id="affiliation" name="affiliation" value="{{ old('affiliation', $user->affiliation) }}" required>

                <button type="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>
