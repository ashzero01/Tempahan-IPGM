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
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">


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

/* Styles specifically for mobile view */
@media (max-width: 480px) {
    /* Make the header more compact */
    .header {
        flex-direction: row; /* Align items in a row */
        align-items: center; /* Center items vertically */
        padding: 5px 10px; /* Reduced padding */
        height: auto; /* Let the height adjust based on content */
        box-shadow: none; /* Optional: remove shadow for a flatter look */
    }

    /* Align the logo to the left and hide the title */
    .header .logo-container {
        flex: 1; /* Allow logo to take available space */
        display: flex;
        align-items: center;
    }

    .header .logo {
        max-width: 60px; /* Reduced logo size */
    }

    .header .header-title {
        display: none; /* Hide the header title on mobile */
    }

    /* Show only the profile icon in the nav links */
    .nav-links {
        margin-left: auto; /* Push nav links to the right */
        display: flex;
        align-items: center; /* Align items vertically */
    }

    .nav-links a {
        display: flex;
        align-items: center;
        margin-left: 10px; /* Space between profile icon and other items */
    }

    /* Hide admin menu and logout button for mobile */
    .admin-menu, .logout-button {
        display: none;
    }

    /* Make buttons container stack vertically on mobile */
    .buttons-container {
        flex-direction: column;
    }

    /* Make custom buttons narrower on mobile */
    .custom-button {
        width: 80%; /* Adjust the width as needed */
        max-width: 300px; /* Set a max-width if desired */
        height: auto;
        font-size: 16px;
    }

    /* Adjust button icon size for mobile */
    .button-icon {
        font-size: 24px;
    }

    /* Adjust button text size for mobile */
    .button-text {
        font-size: 14px;
    }
}

    </style>

    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
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

<!-- Breadcrumb Section -->
<div class="breadcrumb">
    <a href="#" class="active">Halaman Utama</a>
</div>

<!-- Main Content Container -->
<div class="main-container">
    <div class="main-content">
        <!-- Buttons Container -->
        <div class="buttons-container">
            <!-- Tempah Bilik Button -->
            <a href="{{ route('rooms.index') }}" class="custom-button">
                <div class="button-icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="button-text">
                    Tempah Bilik dan Dewan
                </div>
            </a>
            <!-- Tempah Kenderaan Button -->
            <a href="{{ route('vehicles.book') }}" class="custom-button">
                <div class="button-icon">
                    <i class="fas fa-car"></i>
                </div>
                <div class="button-text">
                    Tempah Kenderaan
                </div>
            </a>
            <!-- Lihat Tempahan Bilik Button -->
            <a href="{{ route('bookings.user', ['user_id' => auth()->id()]) }}" class="custom-button">
                <div class="button-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="button-text">
                    Lihat Tempahan Bilik dan Dewan
                </div>
            </a>
            <!-- Lihat Tempahan Kenderaan Button -->
            <a href="{{ route('vehicle.bookings.index') }}" class="custom-button">
                <div class="button-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="button-text">
                    Lihat Tempahan Kenderaan
                </div>
            </a>
            <!-- Kemaskini Profil Button -->
            <a href="{{ route('editprofile') }}" class="custom-button">
                <div class="button-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="button-text">
                    Kemaskini Profil
                </div>
            </a>
        </div>
    </div>
</div>


<footer class="about-footer">
        <p>&copy; 2024 Hakcipta Terpelihara IPG Kampus Kota Bharu</p>
        <a href="{{ route('about') }}" class="footer-link">Mengenai Kami</a>
    </footer>
</body>

</html>
