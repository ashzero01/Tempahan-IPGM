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
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.6.0-web/css/all.min.css') }}">

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

        .user-info-table {
            margin-top: 1rem;
            width: 100%;
        }

        .user-info-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-info-table thead {
            background-color: #F3F4F6;
        }

        .user-info-table th, .user-info-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        .user-info-table th {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4B5563;
            text-transform: uppercase;
            position: relative;
        }

        .user-info-table td {
            font-size: 0.875rem;
            color: #6B7280;
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

<!-- Breadcrumb Section -->
<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Halaman Utama</a>
    <span>&gt;</span>
    <a href="{{ route('vehicle.bookings.index') }}">Senarai Tempahan Kenderaan</a>
    <span>&gt;</span>
    <a href="#" class="active">Butiran Tempahan Kenderaan</a>
</div>


    <!-- Main Content Section -->
    <div class="main-container">
        <div class="page-title">
            Butiran Tempahan untuk {{ $destination }} pada {{ $timestamp }}
        </div>
        <div class="main-content">
            @if($bookings->isEmpty())
                <p>Tiada tempahan dijumpai.</p>
            @else
                

                <!-- Booking Details Table -->
                <div class="table-container">
                    <h2>Maklumat Tempahan</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th>Destinasi</th>
                                <td>{{ $destination }}</td>
                            </tr>
                            <tr>
                                <th>Tujuan</th>
                                <td>{{ $bookings->first()->purpose }}</td>
                            </tr>
                            <tr>
                                <th>Tarikh Bertolak</th>
                                <td>{{ $bookings->first()->departure_date }}</td>
                            </tr>
                            <tr>
                                <th>Masa Bertolak</th>
                                <td>{{ $bookings->first()->departure_time }}</td>
                            </tr>
                            <tr>
                                <th>Tarikh Pulang</th>
                                <td>{{ $bookings->first()->return_date }}</td>
                            </tr>
                            <tr>
                                <th>Masa Pulang</th>
                                <td>{{ $bookings->first()->return_time }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Vehicle Details Table -->
                <div class="table-container">
                    <h2>Kenderaan Ditempah</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Kenderaan</th>
                                <th>No Plat Pendaftaran</th>
                                <th>Jenis Kenderaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->vehicle->name }}</td>
                                    <td>{{ $booking->vehicle->registration_number }}</td>
                                    <td>{{ $booking->vehicle->type }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- User Information Table -->
                <div class="table-container">
                    <h2>Maklumat Pemohon</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Pemohon</th>
                                <th>No Telefon</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>{{ $bookings->first()->user->name }}</td>
                                    <td>{{ $bookings->first()->user->phone_number }}</td>
                                </tr>
                        </tbody>
                    </table>
        </div>

        
    </div>

    <!-- Approve/Reject Buttons -->
    <form action="{{ route('vehicle.bookings.approve', [$timestamp, $destination]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Approve</button>
        </form>

        <form action="{{ route('vehicle.bookings.reject', [$timestamp, $destination]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
</body>
</html>
