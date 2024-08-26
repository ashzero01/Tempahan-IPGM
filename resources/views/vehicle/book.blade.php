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
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">
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

        .vehicle-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px;
        }

        .vehicle-box {
            width: calc(25%);
            padding: 28px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s ease;
            cursor: pointer;
            position: relative; /* Position relative to align the delete button */
        }

        .vehicle-box:hover {
            transform: translateY(-5px);
        }

        .vehicle-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .vehicle-name {
            font-size: 18px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 10px;
        }

        .vehicle-link {
            display: block;
            color: #4a90e2;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .vehicle-link:hover {
            color: #357bd8;
        }

        .page-title {
            padding: 1rem;
            font-size: 2rem;
            color: #333333;
        }

       /* General Styles for Dropdown */
.filter-dropdown {
    position: relative;
    display: inline-block;
}

.filter-dropdown-button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    background-color: #E5E7EB;
    color: #333333;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    text-align: left;
    width: 100%; /* Adjust width as needed */
}

.filter-text {
    flex: 1;
}

.filter-dropdown-button i {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

/* Arrow Rotation When Dropdown is Open */
.filter-dropdown.open .filter-dropdown-button i {
    transform: rotate(90deg);
}

/* Dropdown Content */
.filter-dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: #ffffff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 0.375rem;
    z-index: 1000;
}

.filter-dropdown-content button {
    display: block;
    width: 100%;
    padding: 0.5rem;
    background-color: #E5E7EB;
    color: #333333;
    border: none;
    text-align: left;
    cursor: pointer;
    border-bottom: 1px solid #dddddd;
}

.filter-dropdown-content button:last-child {
    border-bottom: none;
}

.filter-dropdown-content button.active {
    background-color: #3B82F6;
    color: white;
}
        

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            background-color: #4a90e2;
            color: white;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #357bd8;
        }

        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #d9534f;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #c9302c;
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
    }

    /* Main container and page title */
    .main-container {
        padding: 0px;
        margin-top: 15px; /* Space for fixed header */
    }



       .filter-buttons {
        display: flex;
        flex-direction: column;
        width: 100%; /* Full width for dropdown */
    }

    .filter-button {
        display: none; /* Hide individual buttons */
    }

    .filter-dropdown {
    position: relative;
    display: inline-block;
}

.filter-dropdown-button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 0.5rem;
    font-size: 0.875rem;
    background-color: #E5E7EB;
    color: #333333;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    text-align: left;
    position: relative;
}

.filter-text {
    flex: 1;
}

.filter-dropdown-button i {
    margin-left: 0.5rem;
    transition: transform 0.3s ease, color 0.3s ease;
}

.filter-dropdown.open .filter-dropdown-button i {
    transform: rotate(90deg); /* Rotate arrow when dropdown is open */
}

.filter-dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: #ffffff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 0.375rem;
    z-index: 1000;
}

.filter-dropdown-content button {
    display: block;
    width: 100%;
    padding: 0.5rem;
    background-color: #E5E7EB;
    color: #333333;
    border: none;
    text-align: left;
    cursor: pointer;
    border-bottom: 1px solid #dddddd;
}

.filter-dropdown-content button:last-child {
    border-bottom: none;
}

.filter-dropdown-content button.active {
    background-color: #3B82F6;
    color: white;
}


    /* Vehicle container and boxes */
    .vehicle-container {
        flex-direction: column; /* Stack vehicle boxes vertically */
        gap: 15px;
        padding: 0; /* Remove extra padding */
    }

    .vehicle-box {
        width: 95%; /* Full width for vehicle boxes */
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        position: relative; /* Position relative to align delete button */
        transition: transform 0.3s ease;
    }

    .vehicle-image {
        height: 250px; /* Adjust image height for mobile */
    }

    .vehicle-name {
        font-size: 16px;
    }

    .vehicle-link {
        font-size: 14px;
    }

    /* Hide delete button for non-admin users */
    .delete-button {
        display: none;
    }

    /* Back button styles */
    .back-button {
        padding: 8px 16px;
        font-size: 0.75rem;
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
        <a href="{{ route('vehicle.bookings.index') }}">Senarai Tempahan Kenderaan</a>
        <span>&gt;</span>
        <a href="#" class="active">Senarai Kenderaan</a>
    </div>

    <!-- Page Title Section -->
    <div class="main-container">
        <div class="page-title">
            Tempahan Kenderaan
        </div>
        <div class="main-content">
        <div class="filter-buttons">
        <div class="filter-dropdown">
    <button class="filter-dropdown-button">
        <span class="filter-text">Semua Kenderaan</span>
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="filter-dropdown-content">
        <button class="filter-button" data-type="">Semua Kenderaan</button>
        <button class="filter-button" data-type="bas">Bas</button>
        <button class="filter-button" data-type="kereta">Kereta</button>
        <button class="filter-button" data-type="van">Van</button>
        <button class="filter-button" data-type="pajero">Pajero</button>
        <button class="filter-button" data-type="mini bus">Bas Mini</button>
    </div>
</div>
</div>
            <div class="vehicle-container">
    <!-- Vehicle Boxes -->
    @foreach ($vehicles as $vehicle)
        <div class="vehicle-box" data-type="{{ $vehicle->type }}" onclick="window.location='{{ route('vehicles.booking.details', $vehicle->id) }}';">
              <!-- Show delete and edit buttons only for admin users -->
              @if(auth()->user()->role === 'admin')
                        <div class="admin-buttons">
                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button" onclick="return confirm('Adakah anda pasti ingin memadam kenderaan ini?');">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            <a href="{{ route('vehicles.edit.image', $vehicle->id) }}" class="edit-image-button">
                            <i class="fas fa-edit"></i>
                                </a>
                        </div>
                    @endif
            <!-- Vehicle Image -->
            <img src="{{ asset(($vehicle->image ? $vehicle->image : 'default-vehicle.jpg')) }}" alt="{{ $vehicle->name }}" class="vehicle-image">
            <!-- Vehicle Name -->
            <div class="vehicle-name">{{ $vehicle->name }}</div>
            <!-- Link to vehicle bookings -->
            <span class="vehicle-link">Tempah Sekarang</span>
        </div>
    @endforeach
</div>
        </div>
    </div>

    <script>
   document.addEventListener('DOMContentLoaded', function () {
    const filterDropdownButton = document.querySelector('.filter-dropdown-button');
    const filterDropdownContent = document.querySelector('.filter-dropdown-content');
    const filterButtons = document.querySelectorAll('.filter-dropdown-content .filter-button');
    const vehicleBoxes = document.querySelectorAll('.vehicle-box');
    const filterDropdown = document.querySelector('.filter-dropdown');
    const filterText = document.querySelector('.filter-text');

    // Function to update the dropdown button text
    function updateDropdownButtonText(text) {
        filterText.textContent = text;
    }

    // Toggle dropdown content visibility and manage arrow rotation
    filterDropdownButton.addEventListener('click', function () {
        const isOpen = filterDropdownContent.style.display === 'block';
        filterDropdownContent.style.display = isOpen ? 'none' : 'block';
        filterDropdown.classList.toggle('open', !isOpen); // Add/remove class for arrow rotation
    });

    // Filter vehicles and update button text
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to the clicked button
            button.classList.add('active');

            // Close the dropdown after selection
            filterDropdownContent.style.display = 'none';
            filterDropdown.classList.remove('open'); // Reset arrow rotation

            // Update dropdown button text
            updateDropdownButtonText(button.textContent);

            // Filter vehicles
            const selectedType = button.getAttribute('data-type');

            vehicleBoxes.forEach(box => {
                const vehicleType = box.getAttribute('data-type');

                if (selectedType === '' || vehicleType === selectedType) {
                    box.style.display = 'block';
                } else {
                    box.style.display = 'none';
                }
            });
        });
    });
});

</script>

</body>
</html>