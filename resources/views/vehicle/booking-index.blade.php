<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tempahan IPGMKKB</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.6.0-web/css/all.min.css') }}">
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
            padding: 1rem;
            font-size: 2rem;
            color: #333333;
            text-transform: uppercase;
        }

        .table-container {
            margin-top: 1rem;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #F3F4F6;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        th {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4B5563;
            text-transform: uppercase;
            position: relative;
        }

        td {
            font-size: 0.875rem;
            color: #6B7280;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
        }

        .view-button {
            background-color: #3B82F6;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .view-button:hover {
            background-color: #2563EB;
        }

        .booking-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1rem 0;
            font-size: 1.5rem;
            color: #333333;
        }

        .view-button-inline {
            background-color: #3B82F6;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .view-button-inline:hover {
            background-color: #2563EB;
        }

        .delete-button {
            background-color: #F87171;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #EF4444;
        }

        .booking-details {
            margin-bottom: 1rem;
        }

        .vehicle-list {
            margin-left: 2rem;
            list-style-type: none;
            padding: 0;
        }

        .vehicle-item {
            margin-bottom: 0.5rem;
        }

        .status-label {
            font-weight: bold;
            padding: 0.5rem;
            border-radius: 0.375rem;
            color: white;
        }

        .status-pending {
            background-color: black;
        }

        .status-approved {
            background-color: green;
        }

        .status-rejected {
            background-color: red;
        }

        .status-unknown {
            background-color: gray;
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

        .no-bookings-message {
            font-size: 1.25rem;
            color: #6B7280;
        }

        /* Ensure the new column aligns well with others */
        .booking-table th:nth-child(8),
        .booking-table td:nth-child(8) {
            text-align: center;
        }

        .filter-actions-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.filter-buttons {
    display: flex;
    gap: 1rem;
}

.new-action-button-container {
    margin-left: auto;
}

.new-action-button {
    background-color: #3B82F6;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 0.875rem;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.new-action-button:hover {
    background-color: #2563EB;
}

@media (max-width: 480px) {


    .booking-header {
        position: -webkit-sticky; /* For Safari */
        position: sticky;
        top: 0; /* Stick to the top of the viewport */
        background-color: #ffffff; /* Ensure background is solid for readability */
        z-index: 10; /* Make sure it is above other content */
        padding: 0.5rem; /* Space around the content */
        border-bottom: 1px solid #E5E7EB; /* Border for separation */
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .booking-title {
        font-size: 1.25rem; /* Adjust font size */
    }

    .status-label {
        font-size: 1rem; /* Adjust font size */
        padding: 0.5rem; /* Ensure padding is appropriate */
    }

    table {
        width: 100%; /* Ensure table takes full width */
        overflow-x: auto; /* Enable horizontal scrolling */
        display: block; /* Required for horizontal scrolling */
        min-width: 100%; /* Minimum width to ensure table is scrollable */
    }

    .table-container {
        overflow-x: auto; /* Enable horizontal scrolling for the container */
        display: block; /* Required for horizontal scrolling */
        white-space: nowrap; /* Prevent table from wrapping */
    }

    .booking-table th, .booking-table td {
        white-space: nowrap; /* Prevent text from wrapping */
    }
    .action-buttons {
        display: flex;
        flex-direction: column; /* Stack buttons vertically */
        gap: 0.5rem; /* Space between buttons */
        align-items: flex-start; /* Align buttons to the start */
        margin-top: 0.5rem; /* Space above action buttons */
    }

    .delete-button,
    .view-button {
        width: 100%; /* Full width for buttons */
        text-align: center; /* Center text in buttons */
        padding: 0.5rem; /* Ensure buttons have enough padding */
        box-sizing: border-box; /* Include padding and border in element's total width and height */
    }

    .status-label {
        font-size: 1rem; /* Adjust font size for better readability */
        padding: 0.5rem; /* Ensure padding is appropriate */
    }



    .filter-buttons {
        flex-direction: column; /* Stack filter buttons vertically */
    }

    .filter-dropdown-button {
        width: 100%; /* Full width for dropdown button */
        padding: 0.5rem; /* Ensure adequate padding */
    }

    .filter-dropdown-content {
        width: 100%; /* Full width for dropdown content */
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
                <a href="#" class="admin-link"><i class="fas fa-tools"></i> Admin Menu</a>
                <div class="dropdown-content">
                    <a href="#"><i class="fas fa-users"></i> See user list</a>
                    <a href="vehicles"><i class="fas fa-car"></i> See vehicle list</a>
                    <a href="#"><i class="fas fa-user-plus"></i> Add admin</a>
                    <a href="{{ route('rooms.create') }}"><i class="fas fa-plus-square"></i> Add room</a>
                    <a href="{{ route('vehicles.create') }}"><i class="fas fa-truck"></i> Add vehicle</a>
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
    <a href="#" class="active">Senarai Tempahan Kenderaan</a>

    </div>


    <div class="main-container">
        <div class="page-title">
            Senarai Tempahan Kenderaan
        </div>
        <div class="main-content">
        <div class="filter-buttons">
        <div class="filter-dropdown">
    <button class="filter-dropdown-button">
        <span class="filter-text">Semua Status</span>
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="filter-dropdown-content">
        <button class="filter-button" data-type="">Semua Status</button>
        <button class="filter-button" data-type="Menunggu Pengesahan">Menunggu Pengesahan</button>
        <button class="filter-button" data-type="Diterima">Diterima</button>
        <button class="filter-button" data-type="Ditolak">Ditolak</button>
    </div>
</div>
    <div class="new-action-button-container">
        <a href="{{ route('vehicles.book') }}" class="new-action-button">Tempah Kenderaan</a>
    </div>
</div>
            
            <div class="table-container" id="table-container">
                @foreach($bookings as $key => $groupedBookings)
                @php
                    list($timestamp, $destination) = explode('|', $key);
                    $status = $groupedBookings->first()->status;
                    $statusClass = match($status) {
                        'Menunggu Pengesahan' => 'status-pending',
                        'Diterima' => 'status-approved',
                        'Ditolak' => 'status-rejected',
                        default => 'status-unknown',
                    };
                @endphp
                  <!-- Wrap booking-title and status-label in a sticky container -->
<div class="booking-section" data-status="{{ $status }}">
    <div class="booking-header">
        <h2 class="booking-title">
            Tempahan untuk {{ $destination }}
        </h2>
        <div class="action-buttons">
            <form action="{{ route('vehicle.bookings.delete.group', ['timestamp' => $timestamp, 'destination' => $destination]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete all bookings for this group?')">Padam</button>
            </form>
            <a href="{{ route('vehicle.bookings.show', ['timestamp' => $timestamp, 'destination' => $destination]) }}" class="view-button">Lihat</a>
        </div>
    </div>
    <div class="status-label {{ $statusClass }}">
        Status: {{ $status }}
    </div>
                        <table class="booking-table">
                            <thead>
                                <tr>
                                    <th>Tarikh Bertolak</th>
                                    <th>Masa Bertolak</th>
                                    <th>Tarikh Pulang</th>
                                    <th>Masa Pulang</th>
                                    <th>Destinasi</th>
                                    <th>Tujuan</th>
                                    <th>Kenderaan</th>
                                    <th>Bilangan Hari</th> <!-- New Column Header -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentVehicle = '';
                                    $firstBooking = true;
                                @endphp
                                @foreach($groupedBookings as $booking)
                                    @php
                                        $departureDate = \Carbon\Carbon::parse($booking->departure_date);
                                        $returnDate = \Carbon\Carbon::parse($booking->return_date);
                                        $numberOfDays = $departureDate->lte($returnDate) ? $returnDate->diffInDays($departureDate) + 1 : 1;
                                    @endphp
                                    @if($firstBooking || $currentVehicle != $booking->vehicle->name)
                                        <tr data-status="{{ $booking->status }}">
                                            @if($firstBooking)
                                                <td>{{ $booking->departure_date }}</td>
                                                <td>{{ $booking->departure_time }}</td>
                                                <td>{{ $booking->return_date }}</td>
                                                <td>{{ $booking->return_time }}</td>
                                                <td>{{ $booking->destination }}</td>
                                                <td>{{ $booking->purpose }}</td>
                                            @else
                                                <td colspan="7"></td>
                                            @endif
                                            <td>{{ $booking->vehicle->name }}</td>
                                            <td>{{ $numberOfDays }}</td> <!-- New Column Data -->
                                        </tr>
                                        @php
                                            $currentVehicle = $booking->vehicle->name;
                                            $firstBooking = false;
                                        @endphp
                                    @else
                                        <tr data-status="{{ $booking->status }}">
                                            <td colspan="7"></td>
                                            <td>{{ $booking->vehicle->name }}</td>
                                            <td>{{ $numberOfDays }}</td> <!-- New Column Data -->
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
            <div class="no-bookings-message" id="no-bookings-message">
                Tiada tempahan untuk dipaparkan.
            </div>
        </div>
    </div>

   <!-- JavaScript -->
   <!-- JavaScript -->
   <script>
    document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-button');
    const bookingSections = document.querySelectorAll('.booking-section');
    const noBookingsMessage = document.getElementById('no-bookings-message');
    const tableContainer = document.getElementById('table-container');

    // Function to update visibility based on selected filter
    const updateVisibility = () => {
        let anyVisible = false;
        const selectedStatus = document.querySelector('.filter-button.active')?.getAttribute('data-type') || '';

        bookingSections.forEach(section => {
            if (selectedStatus === '' || section.getAttribute('data-status') === selectedStatus) {
                section.style.display = ''; // Show section
                anyVisible = true;
            } else {
                section.style.display = 'none'; // Hide section
            }
        });

        // Show/hide the table container based on visibility of sections
        tableContainer.style.display = anyVisible ? 'block' : 'none';
        noBookingsMessage.style.display = anyVisible ? 'none' : 'block';
    };

    // Event listener for filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to the clicked button
            button.classList.add('active');

            // Update visibility based on the selected filter
            updateVisibility();
        });
    });

    // Initial visibility update
    updateVisibility();

    // Dropdown functionality
    document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
        const button = dropdown.querySelector('.filter-dropdown-button');
        const content = dropdown.querySelector('.filter-dropdown-content');
        const items = content.querySelectorAll('.filter-dropdown-item'); // Select dropdown items

        button.addEventListener('click', () => {
            const isOpen = dropdown.classList.contains('open');
            // Close all dropdowns
            document.querySelectorAll('.filter-dropdown').forEach(d => {
                d.classList.remove('open');
                d.querySelector('.filter-dropdown-content').style.display = 'none';
            });

            // Toggle the clicked dropdown
            if (!isOpen) {
                dropdown.classList.add('open');
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }
        });

        // Add event listeners to dropdown items
        items.forEach(item => {
            item.addEventListener('click', () => {
                dropdown.classList.remove('open');
                content.style.display = 'none';
                // Optional: trigger a filter update or any other action
                const filterType = item.getAttribute('data-filter-type');
                const filterButton = document.querySelector(`.filter-button[data-type="${filterType}"]`);
                if (filterButton) {
                    filterButton.click();
                }
            });
        });
    });
});

</script>


</body>
</html>
