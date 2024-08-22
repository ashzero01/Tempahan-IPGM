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
        <a href="{{ route('register') }}">Daftar untuk Pengguna Baharu</a>
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
            <h1>Tentang Kami</h1>
            <section class="about-section">
                <h2>Misi</h2>
                <p>Memudahkan warga IPGMKKB menjalankan tugas mereka membina generasi akan datang dengan menyediakan kemudahan menempah fasiliti yang tersedia di IPGMKKB</p>
            </section>
            
            <section class="about-section">
                <h2>Anggota Kami</h2>
                <p>1. Amierul Syahmi bin Mohd Hasbi - Developer</p>
            </section>
            
            <section class="about-section">
                <h2>Hubungi Kami</h2>
                <p>Email: amierul2001@gmail.com</p>
            </section>
        </div>
    </main>
    
</body>
</html>
