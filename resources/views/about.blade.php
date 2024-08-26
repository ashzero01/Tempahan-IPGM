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
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">



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
    flex-direction: column; /* Stack breadcrumb and main content vertically */
    align-items: center;
    justify-content: center; /* Center content vertically */
    padding: 20px;
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
    flex-wrap: wrap; /* Allow buttons to wrap if necessary */
    gap: 16px; /* More consistent gap */
    justify-content: center; /* Center buttons horizontally */
    align-items: center; /* Center buttons vertically */
    height: 100%; /* Ensure it takes up the full height available */
}

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
    flex-direction: column; /* Stack icon and text vertically */
    align-items: center;
    justify-content: center;
    font-weight: bold;
    text-align: center;
    color: #ffffff; /* White text color */
    font-size: 18px;
    text-transform: uppercase; /* Make text uppercase */
}

.button-icon {
    font-size: 40px; /* Large icon size */
    margin-bottom: 10px; /* Space between icon and text */
}

.button-text {
    font-size: 16px; /* Adjust text size */
}

.custom-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.centered-title {
    text-align: center;
    font-size: 36px; /* Adjust size as needed */
    margin-bottom: 20px; /* Space below the heading */
}

.about-section {
            margin-bottom: 40px; /* Added bottom margin */
            text-align: center; /* Center align text */
        }

        .about-section h2 {
            font-size: 24px; /* Increased font size */
            margin-bottom: 15px; /* Space below the heading */
        }

        .about-section p {
            font-size: 18px; /* Increased font size */
            line-height: 1.6; /* Improved line height for readability */
            margin: 0; /* Remove default margin */
        }

        .about-section img {
            width: 80px; /* Set a standard width for logos */
            height: auto; /* Maintain aspect ratio */
            display: block;
            margin: 0 auto 20px; /* Center logo and add spacing */
        }
    </style>

    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Header -->
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
                    <a href="#" class="admin-link"><i class="fas fa-tools"></i>Menu Admin</a>
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
    <a href="#" class="active">Tentang Kami</a>
</div>
    
    <!-- Main Content -->
    <main class="main-container">
    <div class="main-content">
        <h1 class="centered-title">Mengenai Kami</h1>

            <section class="about-section">
                <h2><i class="fas fa-bullseye"></i> Visi</h2>
                <p>"IPG Peneraju Kecemerlangan Pendidikan Guru"</p>
            </section>

            <section class="about-section">
            <h2><i class="fas fa-tachometer-alt"></i> Misi</h2>
                <p>"Melahirkan Guru yang kompeten dan berjiwa pendidik melalui program pembangunan guru yang dinamik ke arah pendidikan sekolah bertaraf dunia"</p>
            </section>

            <section class="about-section">
            <h2><i class="fas fa-address-book"></i> Hubungi Kami</h2>
                <p>
                    IPG Kampus Kota Bharu<br>
                    Jalan Maktab, Pengkalan Chepa,<br>
                    16109 Kota Bharu,<br>
                    Kelantan.<br><br>

                    Tel: 09-7717700<br>
                    Faks: 09-7738488
                </p>
            </section>
        </div>
    </main>
    
</body>
</html>
