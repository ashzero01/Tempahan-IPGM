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
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
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

        .view-button, .delete-button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: white;
        }

        .view-button {
            background-color: #3B82F6;
        }

        .view-button:hover {
            background-color: #2563EB;
        }

        .delete-button {
            background-color: #F87171;
        }

        .delete-button:hover {
            background-color: #EF4444;
        }

        .filter-buttons {
            margin-bottom: 1rem;
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
            color: inherit;
            text-decoration: none;
        }

        .sort-link:hover {
            color: #2563EB;
        }

        .sort-icon {
            cursor: pointer;
            display: inline-block;
            font-size: 1rem;
            margin-left: 0.5rem;
            color: #4B5563;
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
        <a href="#" class="active">Senarai Pengguna</a>
    </div>

    <div class="main-container">
        <div class="page-title">Senarai Pengguna</div>
        <div class="main-content">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>No Kad Pengenalan</th>
                            <th>No Telefon</th>
                            <th>Jawatan/Jabatan</th>
                            <th>Peranan</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->ICnumber }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>{{ $user->affiliation }}</td>
                            <td>{{ $user->role }}</td>
                            <td class="actions">
                                <a href="{{ route('showprofile', ['user_id' => $user->id]) }}" class="view-button">Lihat Profil</a>
                                <form method="POST" action="{{ route('users.delete', ['user_id' => $user->id]) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">Hapuskan</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
