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


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh; /* Ensure the body takes up full viewport height */
            display: flex;
            flex-direction: column; /* Stack header and main content vertically */
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
            background-color: #F3F4F6; /* Light gray background for header */
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        th {
            font-size: 0.875rem; /* Consistent font size */
            font-weight: 600;
            color: #4B5563; /* Consistent text color */
            text-transform: uppercase;
            padding: 0.75rem; /* Consistent padding */
            border: none; /* Remove any borders */
            background: none; /* Ensure no background color */
            position: relative; /* For sorting icon positioning */
        }

        td {
            font-size: 0.875rem;
            color: #6B7280; /* Lighter gray for table content */
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .view-button {
            background-color: #3B82F6; /* Blue background color */
            color: white; /* White text color */
            border: none; /* Remove border */
            padding: 0.5rem 1rem; /* Add padding */
            border-radius: 0.375rem; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 0.875rem; /* Font size */
            transition: background-color 0.3s ease; /* Smooth color transition */
            text-decoration: none; /* Remove underline */
        }

        .view-button:hover {
            background-color: #2563EB; /* Darker blue on hover */
        }

        .delete-button {
            background-color: #F87171; /* Red background color */
            color: white; /* White text color */
            border: none; /* Remove border */
            padding: 0.5rem 1rem; /* Add padding */
            border-radius: 0.375rem; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 0.875rem; /* Font size */
            transition: background-color 0.3s ease; /* Smooth color transition */
        }

        .delete-button:hover {
            background-color: #EF4444; /* Darker red on hover */
        }

        .filter-buttons {
            margin-bottom: 1rem; /* Space below filter buttons */
            display: flex;
            gap: 1rem;
        }

        .filter-button {
            padding: 0.5rem 1rem;
            border: 1px solid #E5E7EB;
            border-radius: 0.375rem;
            background-color: #F3F4F6;
            color: #4B5563;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .filter-button.active {
            background-color: #4B5563;
            color: white;
        }

        .filter-button:hover {
            background-color: #E5E7EB;
        }

        .sort-link {
    color: inherit; /* Ensure link color inherits from header */
    text-decoration: none; /* Remove underline */
}

.sort-link:hover {
    color: #2563EB; /* Optional: Change color on hover */
}

.sort-icon {
    cursor: pointer;
    display: inline-block;
    font-size: 1rem;
    margin-left: 0.5rem;
    color: #4B5563; /* Match header text color */
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

        <!-- Breadcrumb Section -->
<div class="breadcrumb">
<a href="{{ route('dashboard') }}">Halaman Utama</a>
    <span>&gt;</span> 
    <a href="#" class="active">Senarai Tempahan Bilik dan Dewan</a>
</div>

    <div class="main-container">
    <div class="page-title">
        Senarai Tempahan Bilik
    </div>
        <div class="main-content">
        <div class="button-container">
    <div class="filter-buttons">
        <button class="filter-button" data-status="">Semua Status</button>
        <button class="filter-button" data-status="Menunggu Pengesahan">Menunggu Pengesahan</button>
        <button class="filter-button" data-status="Diterima">Diterima</button>
        <button class="filter-button" data-status="Ditolak">Ditolak</button>
    </div>
</div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <a href="#" class="sort-link" data-field="date">
                                    <span class="sort-icon" data-field="date" data-direction="{{ $sortField == 'date' ? $sortDirection : 'asc' }}">
                                        {{ $sortField == 'date' ? ($sortDirection == 'asc' ? '↑' : '↓') : '' }}
                                    </span>
                                    Tarikh
                                </a>
                            </th>
                            <th>Hari</th>
                            <th>Masa Mula</th>
                            <th>Masa Tamat</th>
                            <th>Bilik</th>
                            <th>Tujuan</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="booking-table-body">
                        @foreach($bookings as $booking)
                        <tr data-status="{{ $booking->status }}">
                            <td>{{ $booking->date }}</td>
                            <td>
                                @php
                                    $daysOfWeek = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];
                                    $date = new DateTime($booking->date);
                                    $dayIndex = $date->format('w'); // Numeric representation of day (0 for Sunday, 6 for Saturday)
                                    echo $daysOfWeek[$dayIndex];
                                @endphp
                            </td>
                            <td>{{ $booking->formatted_start_time }}</td>
                            <td>{{ $booking->formatted_end_time }}</td>
                            <td>{{ $booking->room->name }}</td>
                            <td>{{ $booking->purpose }}</td>
                            <td>{{ $booking->status }}</td>
                            <td class="actions">
                                <a href="{{ route('bookings.show', ['booking' => $booking->id]) }}" class="view-button">Lihat</a>
                                <form action="{{ route('bookings.delete', ['booking' => $booking->id]) }}" method="POST" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">Padam</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sortLinks = document.querySelectorAll('.sort-link');

            sortLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();

                    const field = link.getAttribute('data-field');
                    const currentDirection = link.querySelector('.sort-icon').dataset.direction;
                    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';

                    // Update the sort direction icon
                    link.querySelector('.sort-icon').dataset.direction = newDirection;
                    link.querySelector('.sort-icon').textContent = newDirection === 'asc' ? '↑' : '↓';

                    // Redirect to the sorted URL
                    const url = new URL(window.location.href);
                    url.searchParams.set('sortField', field);
                    url.searchParams.set('sortDirection', newDirection);
                    window.location.href = url.toString();
                });
            });

            function confirmDelete() {
                return confirm("Anda pasti untuk padamkan tempahan ini?");
            }

            // Filtering functionality
            const filterButtons = document.querySelectorAll('.filter-button');
            const tableRows = document.querySelectorAll('#booking-table-body tr');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const status = button.getAttribute('data-status');

                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to the clicked button
                    button.classList.add('active');

                    // Filter table rows
                    tableRows.forEach(row => {
                        if (status === '' || row.getAttribute('data-status') === status) {
                            row.style.display = ''; // Show row
                        } else {
                            row.style.display = 'none'; // Hide row
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
