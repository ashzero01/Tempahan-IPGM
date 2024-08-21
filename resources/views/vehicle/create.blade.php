<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tempahan IPGM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.6.0-web/css/all.min.css') }}">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumb.css') }}" rel="stylesheet">

    <!-- flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* Image Preview Style */
        #image-preview-container {
            margin-top: 1rem;
        }

        #preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            display: block; /* Ensure it's displayed */
        }

        body {
            font-family: 'Figtree', sans-serif;
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
            max-width: 500px;
            width: 100%;
        }

        .form-container h1 {
            font-size: 24px;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #4B5563;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            font-size: 1rem;
            color: #374151;
            background-color: #F9FAFB;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #3B82F6;
            color: #ffffff;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        button:hover {
            background-color: #2563EB;
        }

        .error-message {
            color: #d9534f;
            background-color: #f2dede;
            border: 1px solid #d9534f;
            padding: 10px;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            box-sizing: border-box; /* Ensure padding and border are included in the element's total width and height */
            overflow: hidden; /* Hide any overflow */
        }

        .form-container {
            overflow: hidden; /* Prevent elements from extending outside */
        }

        .error-message ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .error-message ul li {
            margin-bottom: 5px;
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

    <!-- Breadcrumb Section -->
    <div class="breadcrumb p-4 bg-gray-200">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Halaman Utama</a>
        <span class="mx-2">&gt;</span>
        <a href="{{ route('vehicles.book') }}" class="text-blue-600 hover:underline">Senarai Kenderaan</a>
        <span class="mx-2">&gt;</span>
        <span class="text-gray-600">Tambah Kenderaan Baru</span>
    </div>

    <!-- Main Content Section -->
    <div class="main-container">
        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-container">
            <h1>Tambah Kenderaan Baru</h1>

            <!-- Display success message -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Vehicle creation form -->
            <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="registration_number">No Plat Kenderaan</label>
                    <input type="text" name="registration_number" id="registration_number" class="form-control" value="{{ old('registration_number') }}" required>
                    @error('registration_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="type">Jenis</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="" disabled selected>Pilih Jenis Kenderaan</option>
                        <option value="bas" {{ old('type') === 'bas' ? 'selected' : '' }}>Bas</option>
                        <option value="kereta" {{ old('type') === 'kereta' ? 'selected' : '' }}>Kereta</option>
                        <option value="van" {{ old('type') === 'van' ? 'selected' : '' }}>Van</option>
                        <option value="pajero" {{ old('type') === 'pajero' ? 'selected' : '' }}>Pajero</option>
                        <option value="mini bus" {{ old('type') === 'mini bus' ? 'selected' : '' }}>Bas Mini</option>
                    </select>
                    @error('type')
                        <div class="text-danger text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Preview Container -->
                <div id="image-preview-container">
                    <img id="preview" src="" alt="Image Preview" style="display: none;">
                </div>

                <button type="submit" class="btn btn-primary">Tambah Kenderaan</button>
            </form>
        </div>
    </div>

    <!-- JavaScript for Image Preview -->
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show the image preview
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none'; // Hide the image preview
            }
        });
    </script>
</body>
</html>
