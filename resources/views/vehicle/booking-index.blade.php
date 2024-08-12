<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Tempahan Kenderaan</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
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

        .filter-buttons {
            margin-bottom: 1rem;
        }

        .filter-button {
            background-color: #E5E7EB;
            color: #333333;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
        }

        .filter-button.active {
            background-color: #3B82F6;
            color: white;
        }

        .no-bookings-message {
            font-size: 1.25rem;
            color: #6B7280;
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
                <button type="submit" class="logout-button">Log Keluar</button>
            </form>
        </div>
    </header>

    <div class="main-container">
        <div class="page-title">
            Senarai Tempahan Kenderaan
        </div>
        <div class="main-content">
            <div class="filter-buttons">
                <button class="filter-button" data-status="">Semua Status</button>
                <button class="filter-button" data-status="Menunggu Pengesahan">Menunggu Pengesahan</button>
                <button class="filter-button" data-status="Diterima">Diterima</button>
                <button class="filter-button" data-status="Ditolak">Ditolak</button>
            </div>
            <a href="{{ route('dashboard') }}" class="back-button">&#129152;</a>
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
                    <div class="booking-section" data-status="{{ $status }}">
                        <h2 class="booking-title">
                            Tempahan untuk {{ $destination }}
                            <div class="action-buttons">
                                <form action="{{ route('vehicle.bookings.delete.group', ['timestamp' => $timestamp, 'destination' => $destination]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete all bookings for this group?')">Padam</button>
                                </form>
                                <a href="{{ route('vehicle.bookings.show', ['timestamp' => $timestamp, 'destination' => $destination]) }}" class="view-button">Lihat</a>
                            </div>
                        </h2>
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
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentVehicle = '';
                                    $firstBooking = true;
                                @endphp
                                @foreach($groupedBookings as $booking)
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
                                                <td colspan="6"></td>
                                            @endif
                                            <td>{{ $booking->vehicle->name }}</td>
                                        </tr>
                                        @php
                                            $currentVehicle = $booking->vehicle->name;
                                            $firstBooking = false;
                                        @endphp
                                    @else
                                        <tr data-status="{{ $booking->status }}">
                                            <td colspan="6"></td>
                                            <td>{{ $booking->vehicle->name }}</td>
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
   <script>
            document.addEventListener('DOMContentLoaded', () => {
            const filterButtons = document.querySelectorAll('.filter-button');
            const bookingSections = document.querySelectorAll('.booking-section');
            const noBookingsMessage = document.getElementById('no-bookings-message');
            const tableContainer = document.getElementById('table-container');

            // Show/hide sections based on the number of bookings
            const updateVisibility = () => {
                let anyVisible = false;
                const selectedStatus = document.querySelector('.filter-button.active')?.getAttribute('data-status') || '';

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
        });
    </script>
</body>
</html>
