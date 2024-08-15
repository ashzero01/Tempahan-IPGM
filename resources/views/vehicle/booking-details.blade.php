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
            color: #1F2937; /* Darker text color for better contrast */
            text-transform: uppercase;
        }

        td {
            font-size: 0.875rem;
            color: #000000; /* Black text color */
        }

        /* Specific styles for consistent column widths */
        .booking-details th, .booking-details td {
            width: 33.33%; /* Equal width for each column */
        }

        .vehicle-details th, .vehicle-details td {
            width: 33.33%; /* Equal width for each column */
        }

        .user-info th, .user-info td {
            width: 33.33%; /* Equal width for each column */
        }

        /* Styles for Maklumat Tempahan table */
        .booking-details {
            border-collapse: separate;
            border-spacing: 0 1rem; /* Space between rows */
        }

        .booking-details th, .booking-details td {
            text-align: left;
        }

        .booking-details .title-cell {
            text-align: left;
            font-weight: bold;
        }

        .booking-details .info-cell {
            text-align: right;
        }

        .actions, .button-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .print-button {
            background-color: #10B981; /* Green background */
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .print-button:hover {
            background-color: #059669; /* Darker green */
        }

        .btn-success {
            background-color: #10B981; /* Green background */
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #059669; /* Darker green */
        }

        .btn-danger {
            background-color: #F87171; /* Red background */
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #EF4444; /* Darker red */
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
          @php
  $departureTime = \Carbon\Carbon::parse($bookings->first()->departure_time);
  $returnTime = \Carbon\Carbon::parse($bookings->first()->return_time);

  $formatTime = function ($time) {
      $hour = $time->format('g'); // 12-hour format without leading zero
      $minute = $time->format('i'); // Minutes
      $suffix = 'pagi'; // Default suffix

      if ($time->hour >= 19) {
          $suffix = 'malam';
      } elseif ($time->hour >= 12) {
          $suffix = 'petang';
      }

      return $hour . ':' . $minute . ' ' . $suffix;
  };
@endphp

              <!-- Booking Details Table -->
              <div class="table-container">
                  <h2>Maklumat Tempahan</h2>
                  <table class="booking-details">
                      <tbody>
                          <tr>
                              <td class="title-cell">Destinasi</td>
                              <td class="info-cell">{{ $destination }}</td>
                          </tr>
                          <tr>
                              <td class="title-cell">Tujuan</td>
                              <td class="info-cell">{{ $bookings->first()->purpose }}</td>
                          </tr>
                          <tr>
                              <td class="title-cell">Tarikh Bertolak</td>
                              <td class="info-cell">{{ $bookings->first()->departure_date }}</td>
                          </tr>
                          <tr>
                              <td class="title-cell">Masa Bertolak</td>
                              <td class="info-cell">{{ $formatTime($departureTime) }}</td>
                          </tr>
                          <tr>
                              <td class="title-cell">Tarikh Pulang</td>
                              <td class="info-cell">{{ $bookings->first()->return_date }}</td>
                          </tr>
                          <tr>
                              <td class="title-cell">Masa Pulang</td>
                              <td class="info-cell">{{ $formatTime($returnTime) }}</td>
                          </tr>
                      </tbody>
                  </table>
              </div>

              <!-- Vehicle Details Table -->
              <div class="table-container">
                  <h2>Kenderaan Ditempah</h2>
                  <table class="vehicle-details">
                      <thead>
                          <tr>
                              <th>Kenderaan</th>
                              <th>No Plat Pendaftaran</th>
                              <th>Jenis Kenderaan</th>
                                <th>Nama Pemandu</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($bookings as $booking)
                              <tr>
                                  <td>{{ $booking->vehicle->name }}</td>
                                  <td>{{ $booking->vehicle->registration_number }}</td>
                                  <td>{{ $booking->vehicle->type }}</td>
                                  <td>{{ $bookings->first()->driver_name }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          @endif

          <!-- User Information Table -->
              <div class="table-container">
                  <h2>Maklumat Pemohon</h2>
                  <table class="user-info">
                      <thead>
                          <tr>
                            <th>Unit</th>
                              <th>Nama Pemohon</th>
                              <th>No Kad Pengenalan</th>
                              <th>No Telefon</th>
                          </tr>
                      </thead>
                      <tbody>
                              <tr>
                                    <td>{{ $bookings->first()->unit_name}}</td>
                                  <td>{{ $bookings->first()->user->name }}</td>
                                    <td>{{ $bookings->first()->user->ICnumber }}</td>
                                  <td>{{ $bookings->first()->user->phone_number }}</td>
                              </tr>
                      </tbody>
                  </table>
      </div>

      <!-- Buttons Container -->
      <div class="button-container">
          <a href="{{ route('vehicle.bookings.generatePdf', ['timestamp' => $timestamp, 'destination' => $destination]) }}" class="print-button no-print">Muat Turun Dalam Borang</a>
          <div class="actions">
    @if(Auth::user()->isAdmin())
        @if(!$bookings->first()->driver_name)
            <!-- If driver name is empty, show Assign Driver button -->
            <a href="{{ route('vehicle.bookings.assign.driver', ['timestamp' => $timestamp, 'destination' => $destination]) }}" class="btn btn-warning">
                Tugaskan Pemandu
            </a>
            <form action="{{ route('vehicle.bookings.approve', [$timestamp, $destination]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Approve</button>
            </form>

            <form action="{{ route('vehicle.bookings.reject', [$timestamp, $destination]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>
        @else
            <form action="{{ route('vehicle.bookings.approve', [$timestamp, $destination]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Approve</button>
            </form>

            <form action="{{ route('vehicle.bookings.reject', [$timestamp, $destination]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>      
        @endif
    @endif
</div>


  </div>
</body>
</html>
