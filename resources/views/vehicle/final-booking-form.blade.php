<!DOCTYPE html>
<html>
<head>
    <title>Final Booking Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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

    

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
            max-width: 800px; /* Adjust max-width for a wider form */
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem; /* Space between columns */
}

.full-width {
    grid-column: span 2;
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

        .input-container .icon-clock {
            font-size: 1.25rem; /* Adjust icon size */
        }

        .input-container .icon-location,
        .input-container .icon-purpose {
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
            margin-top: 1rem; /* Space above the button */
        }

        button:hover {
            background-color: #357bd8;
        }

          /* Styles specifically for mobile view */
  @media (max-width: 480px) {

    
    .form-container {
        padding: 1.5rem;
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 80%;
        margin: 0 auto;
    }

    .form-container h1 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        text-align: center;
        color: #333;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .full-width {
        grid-column: span 1;
    }

    .input-container {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .input-container input[type="text"] {
        width: 100%;
        padding: 1rem 2.5rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        box-sizing: border-box;
        font-size: 1.25rem;
    }

    .input-container .icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #4a90e2;
    }

    .input-container .icon-calendar {
        font-size: 1.5rem;
    }

    .input-container .icon-clock {
        font-size: 1.25rem;
    }

    button {
        display: block;
        width: 100%;
        padding: 0.75rem;
        background-color: #007bff;
        color: #ffffff;
        border: none;
        border-radius: 0.375rem;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 1rem;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error-message {
        padding: 1rem;
        font-size: 0.875rem;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }

    .error-message ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .error-message ul li {
        margin-bottom: 0.5rem;
    }

      /* Ensure Flatpickr input fields have adequate size and padding on mobile */
      .flatpickr-input {
            font-size: 1rem; /* Adequate font size */
            padding: 0.75rem; /* Adequate touch target */
        }

        /* Adjust time picker dropdown for mobile */
        .flatpickr-time {
            font-size: 1rem; /* Larger font size for readability */
        }

        /* Adjust time components */
        .flatpickr-time .flatpickr-hour,
        .flatpickr-time .flatpickr-minute {
            width: 50%; /* Make sure components are well sized */
        }

        /* Style the time picker elements for better mobile experience */
        .flatpickr-time .flatpickr-time-separator {
            display: none; /* Hide separator if it causes layout issues */
        }

        /* Ensure that the Flatpickr time picker has proper width */
        .flatpickr-time {
            width: 100%; /* Ensure full width on mobile */
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
    <a href="{{ route('vehicles.booking.details', $vehicle->id) }}" class="active">Pilih Tarikh</a>
    <span>&gt;</span>
    <a href="#" class="active">Siapkan Tempahan</a>
    

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
            <h1>Siapkan Tempahan untuk {{ $vehicle->name }}</h1>
            <form action="{{ route('vehicles.booking.store', $vehicle->id) }}" method="POST">
                @csrf
                <div class="form-grid">
    <div>
        <label for="departure_date">Tarikh Pergi:</label>
        <div class="input-container">
            <i class="icon icon-calendar fas fa-calendar-alt"></i>
            <input type="text" id="departure_date_display" value="{{ $departureDate }}" readonly>
            <input type="hidden" name="departure_date" value="{{ $departureDate }}">
        </div>
    </div>
    <div>
        <label for="return_date">Tarikh Balik:</label>
        <div class="input-container">
            <i class="icon icon-calendar fas fa-calendar-alt"></i>
            <input type="text" id="return_date_display" value="{{ $returnDate }}" readonly>
            <input type="hidden" name="return_date" value="{{ $returnDate }}">
        </div>
    </div>
    <div>
        <label for="departure_time">Masa Bertolak:</label>
        <div class="input-container">
            <i class="icon icon-clock fas fa-clock"></i>
            <input type="text" id="departure_time" name="departure_time" required placeholder="Pilih Masa Bertolak">
        </div>
    </div>
    <div>
        <label for="return_time">Masa Pulang:</label>
        <div class="input-container">
            <i class="icon icon-clock fas fa-clock"></i>
            <input type="text" id="return_time" name="return_time" required placeholder="Pilih Masa Pulang">
        </div>
    </div>
    
    <!-- Unit Field on its Own Row -->
    <div class="full-width">
        <label for="unit_name">Nama Unit:</label>
        <div class="input-container">
            <i class="icon icon-location fas fa-map-marker-alt"></i>
            <input type="text" id="unit_name" name="unit_name" required placeholder="Nyatakan Unit">
        </div>
    </div>
    
    <!-- Destination and Purpose on the Same Row -->
    <div>
        <label for="destination">Destinasi:</label>
        <div class="input-container">
            <i class="icon icon-location fas fa-map-marker-alt"></i>
            <input type="text" id="destination" name="destination" required placeholder="Nyatakan Destinasi">
        </div>
    </div>
    <div>
        <label for="purpose">Tujuan:</label>
        <div class="input-container">
            <i class="icon icon-purpose fas fa-briefcase"></i>
            <input type="text" id="purpose" name="purpose" required placeholder="Nyatakan Tujuan">
        </div>
    </div>
</div>
                <button type="submit">Sahkan Tempahan</button>
            </form>
        </div>
    </div>

    <!-- Flatpickr Initialization -->
    <script>
        flatpickr("#departure_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",  // 12-hour format with AM/PM
            time_24hr: false       // 12-hour format

        });

        flatpickr("#return_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",  // 12-hour format with AM/PM
            time_24hr: false       // 12-hour format

        });
    </script>
</body>
</html>
