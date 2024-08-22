<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Tempahan IPGMKKB</title>
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">



    <!-- Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('{{ asset('images/background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .header {
            background-color: #1F2937; /* Dark gray background */
            padding: 1rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            max-height: 40px; /* Set a maximum height for the logo */
            max-width: 100px; /* Set a maximum width for the logo */
            margin-right: 1rem; /* Space between logo and text */
        }

        .header-title {
            font-size: 1.5rem; /* Adjust as needed */
            color: white;
            margin: 0; /* Remove default margin */
        }

        .header a {
            color: #E5E7EB; /* Light gray for links */
            text-decoration: none;
            margin: 0 1rem;
            font-weight: 500;
        }

        .header a:hover {
            color: #60A5FA; /* Lighter blue on hover */
        }

        .main-content {
            text-align: center;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.8); /* White background with opacity */
            border-radius: 0.5rem;
            margin: 2rem auto;
            max-width: 600px;
        }

        .main-content h1 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #111827; /* Dark gray */
            margin-bottom: 1rem;
        }

        .main-content p {
            color: #555;
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .login-form {
            margin-top: 2rem;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }

        .login-form input[type="text"], .login-form input[type="email"], .login-form input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            box-sizing: border-box;
            font-size: 1.125rem; /* Increase text size */
            text-align: center; /* Horizontally center the text */
            line-height: 1.5; /* Adjust line height for vertical alignment */
        }

        .login-form button {
            width: 100%;
            padding: 0.75rem;
            background-color: #2563EB;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #1D4ED8;
        }

        .error-message {
            color: #DC2626; /* Red color for error messages */
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        /* Mobile View Styles */
@media (max-width: 768px) {


/* Main content styles */
.main-content {
    padding: 1rem;
    background-color: rgba(255, 255, 255, 0.9); /* More opaque white background */
    border-radius: 0.5rem;
    margin: 1rem auto;
    max-width: 90%; /* Reduce max-width for mobile */
    margin-top: 3rem; /* Adjust margin top for better spacing */
}

.main-content h1 {
    font-size: 1.75rem; /* Smaller heading for mobile */
    margin-bottom: 1rem;
}

.main-content p {
    font-size: 0.875rem; /* Smaller text for mobile */
    margin-bottom: 1.5rem;
}

.login-form {
    padding: 1rem;
    max-width: 90%;
    margin: 0 auto;
}

.login-form input[type="text"], 
.login-form input[type="password"] {
    padding: 0.5rem;
    font-size: 1rem; /* Adjust font size for inputs */
}

.login-form button {
    padding: 0.5rem;
    font-size: 1rem; /* Adjust font size for button */
}

/* Footer styles */
.about-footer {
    padding: 1rem;
    text-align: center;
    font-size: 0.875rem; /* Smaller font size for footer */
}

.about-footer a {
    color: #2563EB; /* Link color */
    text-decoration: none;
}

.about-footer a:hover {
    text-decoration: underline;
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
            <a href="/">Balik ke Halaman Utama</a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Daftar Pengguna</h1>
        <p>Sila isi maklumat berikut untuk mendaftar.</p>

        <!-- Register Form -->
        <div class="login-form">
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label for="name" style="display: block; margin-bottom: 0.5rem;">Nama</label>
                    <input id="name" type="text" name="name" required autofocus>
                </div>


                <div>
                    <label for="ICnumber" style="display: block; margin-bottom: 0.5rem;">No Kad Pengenalan</label>
                    <input id="ICnumber" type="text" name="ICnumber" required>
                </div>

                <div>
                    <label for="phone_number" style="display: block; margin-bottom: 0.5rem;">No Telefon</label>
                    <input id="phone_number" type="text" name="phone_number">
                </div>

                <div>
                    <label for="affiliation" style="display: block; margin-bottom: 0.5rem;">Jawatan/Jabatan</label>
                    <input id="affiliation" type="text" name="affiliation">
                </div>

                <button type="submit">Daftar</button>
            </form>
        </div>
    </div>


</body>

</html>
