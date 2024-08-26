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

    .container {
        width: 80%;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
        text-align: center;
    }

    .alert {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #d9534f;
        border-radius: 4px;
        background-color: #f2dede;
        color: #a94442;
    }

    .alert ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .alert li {
        margin-bottom: 5px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #555;
    }

    .form-group input[type="file"] {
        display: block;
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
    }

    .form-group img {
        display: block;
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-top: 10px;
    }

    .current-image img {
        max-width: 400px;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .preview-image img {
        max-width: 400px; /* Adjust size as needed */
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-top: 10px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
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
        <a href="{{ route('bookings.user', ['user_id' => auth()->id()]) }}">Senarai Tempahan Bilik dan Dewan</a>
        <span>&gt;</span>
        <a href="{{ route('rooms.index') }}">Senarai Bilik dan Dewan</a>
        <span>&gt;</span>
        <a href="#" class="active">Tukar Gambar Baru</a>
    </div>


<div class="container">
<h2>Tukar Gambar Baru {{ $room->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Show the previous image -->
    <div class="form-group current-image">
        <label>Gambar Sekarang:</label>
        <div>
            <img src="{{ asset($room->image ? $room->image : 'default-vehicle.jpg') }}" alt="{{ $room->name }}">
        </div>
    </div>

    <!-- Preview the next image -->
    <div class="form-group preview-image">
        <label>Gambar Baru:</label>
        <div>
            <img id="newImagePreview" src="#" alt="New Image" style="display: none;">
        </div>
    </div>

    <form action="{{ route('rooms.update.image', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <input type="file" name="image" class="form-control" id="imageInput" onchange="previewImage(event)">
        </div>

        <button type="submit" class="btn btn-primary">Tukar Gambar Baru</button>
    </form>
</div>

<script>
    function previewImage(event) {
        const imageInput = document.getElementById('imageInput');
        const newImagePreview = document.getElementById('newImagePreview');

        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                newImagePreview.src = e.target.result;
                newImagePreview.style.display = 'block';
            };

            reader.readAsDataURL(imageInput.files[0]);
        }
    }
</script>
