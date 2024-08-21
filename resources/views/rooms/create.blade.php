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
        <div class="logo-container flex items-center space-x-4 p-4 bg-gray-800 text-white">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo w-12 h-12">
            <h2 class="header-title text-xl font-semibold">Sistem Tempahan Bilik dan Kenderaan</h2>
        </div>
        <div class="nav-links p-4 bg-gray-100">
            <a href="{{ route('showprofile', ['user_id' => auth()->user()->id]) }}" class="profile-link text-blue-600 hover:underline">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
            </a>

            <!-- Admin Menu -->
            @if(auth()->user()->role === 'admin')
                <div class="admin-menu relative inline-block">
                    <a href="#" class="admin-link text-blue-600 hover:underline"><i class="fas fa-tools"></i> Menu Admin</a>
                    <div class="dropdown-content absolute mt-2 w-48 bg-white border border-gray-300 shadow-lg rounded-md">
                        <a href="{{route('users.list')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="fas fa-users"></i> Senarai Pengguna</a>
                        <a href="{{route('vehicles.book')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="fas fa-car"></i> Senarai Kenderaan</a>
                        <a href="{{route('showAddAdminForm')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="fas fa-user-plus"></i> Tambah Admin</a>
                        <a href="{{ route('rooms.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="fas fa-plus-square"></i> Tambah Bilik</a>
                        <a href="{{ route('vehicles.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="fas fa-truck"></i> Tambah Kenderaan</a>
                    </div>
                </div>
            @endif

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="logout-button flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white p-2 rounded">
                    <i class="fas fa-sign-out-alt"></i> Log Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Breadcrumb Section -->
    <div class="breadcrumb p-4 bg-gray-200">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Halaman Utama</a>
        <span class="mx-2">&gt;</span>
        <a href="{{ route('rooms.index') }}" class="text-blue-600 hover:underline">Senarai Bilik</a>
        <span class="mx-2">&gt;</span>
        <span class="text-gray-600">Tambah Bilik dan Dewan Baru</span>
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
            <h1 class="text-xl font-bold">Tambah Bilik</h1>
            <!-- Room Creation Form -->
            <div class="mt-4">
            <form id="room-form" onsubmit="submitForm(); return false;" action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
                    <!-- Room Name -->
                    <div class="form-group">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Bilik/Dewan</label>
                        <input type="text" name="name" id="name" class="p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>

                    <!-- Description -->
                    <div class="form-group">
    <label for="description" class="block text-sm font-medium text-gray-700">Jenis</label>
    <select name="description" id="description" class="p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        <option value="" disabled selected>Pilih Jenis</option>
        <option value="bilik">Bilik</option>
        <option value="dewan">Dewan</option>
    </select>
</div>

                    <!-- Image Upload -->
                    <div class="form-group">
                        <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                        <input type="file" name="image" id="image" class="p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" onchange="previewImage(event)">
                    </div>

            <!-- Image Preview -->
         <!-- Image Preview -->
<div id="image-preview-container">
    <img id="preview" class="room-image" style="display: none;">
</div>
            <div>
                    <!-- Submit Button -->
                    <div class="mt-4">
                    <button type="submit" class="create-room-button bg-blue-600 hover:bg-blue-700 text-white p-2 rounded">Tambah Bilik/Dewan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
       const roomsIndexRoute = "{{ route('rooms.index') }}";

function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('preview');
    var previewContainer = document.getElementById('image-preview-container');

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}

function submitForm() {
    document.getElementById('message-area').innerHTML = '';
    
    var roomForm = document.getElementById('room-form');
    var formData = new FormData(roomForm);
    
    // Add CSRF token to form data
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch(roomForm.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to the "Senarai Bilik" page
            window.location.href = "{{ route('rooms.index') }}";
        } else {
            // Handle validation errors
            var messageArea = document.getElementById('message-area');
            messageArea.innerHTML = `<div class="text-red-500">${data.message}</div>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        var messageArea = document.getElementById('message-area');
        messageArea.innerHTML = `<div class="text-red-500">An unexpected error occurred. Please try again.</div>`;
    });
}
    </script>
</body>
</html>
