<!DOCTYPE html>
<html>
<head>
    <title>Sistem Tempahan IPGM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">



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


          /* Styles specifically for mobile view */
  @media (max-width: 480px) {
   /* Header styles for mobile */
   .header {
            flex-direction: row; /* Align items in a row */
            align-items: center; /* Center items vertically */
            padding: 5px 10px; /* Reduced padding */
            height: auto; /* Adjust height based on content */
            box-shadow: none; /* Optional: remove shadow for a flatter look */
        }

        .header .logo-container {
            flex: 1; /* Allow logo to take available space */
            display: flex;
            align-items: center;
        }

        .header .logo {
            max-width: 60px; /* Adjust logo size for mobile */
        }

        .header .header-title {
            display: none; /* Hide the header title on mobile */
        }

        .nav-links {
            margin-left: auto; /* Push nav links to the right */
            display: flex;
            align-items: center; /* Align items vertically */
        }

        .nav-links a {
            display: flex;
            align-items: center;
            margin-left: 10px; /* Space between profile icon and other items */
            font-size: 0.875rem; /* Smaller font size */
        }

        /* Main container and page title */
        .main-container {
            padding: 0px;
            margin-top: 15px; /* Space for fixed header */
        }

        .form-container {
        padding: 1.5rem; /* Increased padding for a more spacious feel */
        background-color: #ffffff; /* White background for the form */
        border-radius: 0.75rem; /* More rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle, slightly larger shadow */
        max-width: 80%; /* Ensure it takes full width */
        margin: 0 auto; /* Center the form container */
    }

    .form-container h1 {
        font-size: 1.5rem; /* Adjust font size for better readability on smaller screens */
        margin-bottom: 1rem; /* Reduced margin for a tighter layout */
        text-align: center; /* Center text */
        color: #333; /* Dark text color for contrast */
    }

    .input-container {
    margin-bottom: 1.5rem; /* Increased space between input fields */
    font-size: 1.25rem; /* Larger font size for readability */
    text-align: center; /* Center text */
    position: relative; /* Ensure icons are correctly positioned */
    width: 100%; /* Ensure it takes the full width */
}

.input-container input[type="text"] {
    padding: 1rem 1.5rem; /* Increased padding for a larger touch area */
    font-size: 1.25rem; /* Larger font size for better readability */
    border: 1px solid #ddd; /* Light border color */
    border-radius: 0.5rem; /* More rounded corners for a larger appearance */
    width: 100%; /* Ensure it takes the full width of the container */
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
}

.input-container .icon-calendar {
    font-size: 1.5rem; /* Larger icon size for better visibility */
    position: absolute; /* Position icon relative to the input field */
    left: 1rem; /* Space from the left edge */
    top: 50%; /* Center vertically */
    transform: translateY(-50%); /* Adjust vertical alignment */
    color: #4a90e2; /* Consistent color with design */
}
    button {
        padding: 0.75rem; /* Adequate padding for touch interactions */
        font-size: 1rem; /* Consistent font size */
        background-color: #007bff; /* Primary button color */
        color: #ffffff; /* White text color */
        border: none; /* Remove default border */
        border-radius: 0.375rem; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        transition: background-color 0.3s ease; /* Smooth transition */
    }

    button:hover {
        background-color: #0056b3; /* Darker color on hover */
    }

    .error-message {
        padding: 1rem; /* Adequate padding for readability */
        font-size: 0.875rem; /* Smaller font size for error messages */
        background-color: #f8d7da; /* Light red background for errors */
        color: #721c24; /* Dark red text color for errors */
        border: 1px solid #f5c6cb; /* Light red border for errors */
        border-radius: 0.375rem; /* Rounded corners for error box */
        margin-bottom: 1rem; /* Space below the error message */
    }

    .error-message ul {
        list-style-type: none; /* Remove default list styles */
        padding: 0; /* Remove padding */
        margin: 0; /* Remove margin */
    }

    .error-message ul li {
        margin-bottom: 0.5rem; /* Space between list items */
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
        