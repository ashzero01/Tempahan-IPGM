<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Tempahan IPGMKKB</title>
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
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
            padding: 1.5rem;
            font-size: 2.5rem;
            color: #333333;
            border-bottom: 2px solid #E5E7EB;
            text-transform: uppercase;

        }

        .main-container {
            flex: 1;
            padding: 2rem;
            background-color: #F9FAFB;
        }

        .main-content {
            position: relative;
            max-width: 800px;
            margin: auto;
            background-color: #FFFFFF;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .booking-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .booking-details-left,
        .booking-details-right {
            width: 48%;
        }

        .booking-details p {
            font-size: 1.125rem;
            color: #4B5563;
            margin-bottom: 1rem;
        }

        .booking-details p span {
            font-weight: 600;
            color: #1F2937;
        }

        .edit-button {
            background-color: #3B82F6;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
            position: absolute;
            bottom: 1rem;
            right: 1rem;
        }

        .edit-button:hover {
            background-color: #2563EB;
        }

        .actions {
            margin-top: 2rem;
            text-align: center;
        }

        .actions .approve-button {
            background-color: #10B981;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin-right: 0.5rem;
        }

        .actions .reject-button {
            background-color: #EF4444;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .actions .approve-button:hover {
            background-color: #059669;
        }

        .actions .reject-button:hover {
            background-color: #DC2626;
        }

        .print-button {
            background-color: #4B5563;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .print-button:hover {
            background-color: #374151;
        }

        @media print {
            .no-print {
                display: none;
            }
            .print-button {
                display: none;
            }
        }

        /* Mobile View Styles */
@media (max-width: 768px) {
    /* Page Title */
    .page-title {
        font-size: 1.75rem; /* Smaller font size for mobile */
        padding: 1rem; /* Reduce padding */
        border-bottom: 1px solid #E5E7EB; /* Thinner border */
    }

    /* Main Container */
    .main-container {
        padding: 1rem; /* Reduce padding */
    }

    /* Main Content */
    .main-content {
        padding: 1rem; /* Reduce padding */
        box-shadow: none; /* Remove shadow for a cleaner look */
        border-radius: 0.25rem; /* Smaller border radius */
        width: 90%;
    }

    /* Booking Details */
    .booking-details {
        flex-direction: column; /* Stack details vertically */
    }

    .booking-details-left,
    .booking-details-right {
        width: 90%; /* Full width for each section */
        margin-bottom: 1rem; /* Space between sections */
    }

    .booking-details p {
        font-size: 1rem; /* Smaller font size */
    }

    .booking-details p span {
        font-weight: 600;
        color: #1F2937;
    }

    /* Edit Button */
    .edit-button {
        position: static; /* Remove absolute positioning */
        margin-top: 1rem; /* Space above button */
        margin-right: 0; /* Remove right margin */
        margin: 1rem auto; /* Center horizontally with auto margins */
        width: 50%; /* Full width button */
        text-align: center; /* Center text */
    }

    /* Action Buttons */
    .actions {
        margin-top: 1.5rem; /* Space above action buttons */
    }

    .print-button{
        position: static; /* Remove absolute positioning */
        margin-top: 1rem; /* Space above button */
        margin-right: 0; /* Remove right margin */
        width: 50%; /* Full width button */
        text-align: center; /* Center text */
    }

    .actions .approve-button,
    .actions .reject-button,
     {
        display: block;
        width: 100%; /* Full width buttons */
        margin-bottom: 0.5rem; /* Space between buttons */
    }


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


     <!-- Breadcrumb Section -->
<div class="breadcrumb">
<a href="{{ route('dashboard') }}">Halaman Utama</a>
    <span>&gt;</span> 
    <a href="{{ route('bookings.user', ['user_id' => auth()->id()]) }}">Senarai Tempahan Bilik dan Dewan</a>
    <span>&gt;</span>
    <a href="#" class="active">Maklumat Tempahan</a>
</div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Page Title -->
        <div class="page-title">
            Maklumat Tempahan
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Booking Details -->
            <div class="booking-details">
                <div class="booking-details-left">
                    <p><span>Bilik:</span> {{ $room->name }}</p>
                    <p><span>Tarikh Tempahan:</span> {{ $booking->date }}</p>
                    <p><span>Hari:</span> {{ $dayDate }}</p>
                    <p><span>Masa Mula:</span> {{ $startTime }}</p>
                    <p><span>Masa Tamat:</span> {{ $endTime }}</p>
                    <p><span>Tujuan:</span> {{ $booking->purpose }}</p>
                </div>
                <div class="booking-details-right">
                    <p><span>Nama Pemohon:</span> {{ $booking->user->name }}</p>
                    <p><span>IC Pemohon:</span> {{ $booking->user->ICnumber}}</p>
                    <p><span>No Tel. Pemohon:</span> {{ $booking->user->phone_number }}</p>
                    <p><span>Jawatan/Jabatan Pemohon:</span> {{ $booking->user->affiliation }}</p>
                    @if(auth()->user()->id === $booking->user_id)
                    <a href="{{ route('editprofile') }}" class="edit-profile-link">Kemaskini Profil</a>
                @endif                </div>
            </div>

           <!-- Edit Button (Visible only for owner or admin) -->
           @if(auth()->user()->id === $booking->user_id || auth()->user()->role === 'admin')
           <a href="{{ route('bookings.edit', ['booking' => $booking->id]) }}" class="edit-button">
               Kemaskini Tempahan
           </a>
       @endif

            <!-- Print Button -->
<div class="actions">
    <!-- Add PDF Download Button -->
    <a href="{{ route('bookings.generatePdf', ['booking' => $booking->id]) }}" class="print-button no-print">Muat Turun Borang</a>
</div>

        </div>

        <!-- Action Buttons (only for admin) -->
@if(auth()->user()->role === 'admin')
    <div class="actions">
        <!-- Approve Button -->
        @if($booking->status !== 'Ditolak')
            <form method="POST" action="{{ route('bookings.approve', ['booking' => $booking->id]) }}" style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="approve-button">Terima</button>
            </form>
        @endif

        <!-- Reject Button -->
        @if($booking->status !== 'Diterima')
            <form method="POST" action="{{ route('bookings.reject', ['booking' => $booking->id]) }}" style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="reject-button">Tolak</button>
            </form>
        @endif
    </div>
@endif

    </div>
</body>

</html>
