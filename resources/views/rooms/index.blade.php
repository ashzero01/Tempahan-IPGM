<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
 
            min-height: 100vh; /* Ensure the body takes up full viewport height */
            display: flex;
            flex-direction: column; /* Stack header and main content vertically */
        }

        .header {
            background-color: #1F2937; /* Dark gray background */
            padding: 1rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            max-height: 40px; /* Set a maximum height for the logo */
            max-width: 100px; /* Set a maximum width for the logo */
            margin-right: 1rem; /* Space between logo and text */
        }

        .header-title {
            font-size: 1.5rem; /* Adjust as needed */
            color: white;
            margin: 0; /* Remove default margin */
        }

        .header a {
            color: #E5E7EB; /* Light gray for links */
            text-decoration: none;
            margin: 0 1rem;
            font-weight: 500;
        }

        .header a:hover {
            color: #60A5FA; /* Lighter blue on hover */
        }

        .main-container {
            flex: 1; /* Take up remaining space */
            display: flex; /* Enable flexbox layout */
            flex-direction: column; /* Stack content vertically */
            align-items: center; /* Center content horizontally */
        }

        .main-content {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
            padding: 20px; /* Adjust padding */
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 1000px; /* Set a maximum width */
            width: 100%; /* Ensure it takes up the full width available */
            box-sizing: border-box; /* Ensure padding and border are included in the width and height */
            margin-top: 3rem; /* Adjust this value as needed */

        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 16px; /* More consistent gap */
        }

        button[type="submit"] {
            background-color: #3490dc;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .room-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px;
        }

        .room-box {
            width: calc(25%); /* Adjust the width as needed */
            padding: 28px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 2px;
            transition: transform 0.3s ease;
            cursor: pointer; /* Add cursor pointer */
        }

        .room-box:hover {
            transform: translateY(-5px);
        }

        .room-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .room-name {
            font-size: 18px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 10px;
        }

        .room-link {
            display: block;
            color: #4a90e2;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .room-link:hover {
            color: #357bd8;
        }

        .add-room-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .add-room-button:hover {
            background-color: #357bd8;
        }

        .delete-room-button-wrapper {
            display: flex;
            justify-content: flex-end; /* Align button to the right */
            margin-top: 10px; /* Add margin for spacing */
        }

        .admin-buttons {
            display: flex;
            justify-content: flex-end; /* Align buttons to the right */
            margin-top: 10px; /* Add margin for spacing */
        }

        .edit-delete-container {
            display: flex;
        }

        .edit-room-button,
        .delete-room-button {
            padding: 6px 12px; /* Adjust padding to make the buttons smaller */
            font-size: 14px; /* Adjust font size to make the button text smaller */
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .edit-room-button {
            background-color: #4a90e2; /* Blue color for edit button */
            color: #ffffff;
            border: none;
            border-radius: 4px 0 0 4px; /* Rounded border for left edge */
        }

        .edit-room-button:hover {
            background-color: #357bd8; /* Darker blue on hover */
        }

        .delete-room-button {
            background-color: #ff0000; /* Red color for delete button */
            color: #ffffff;
            border: none;
            border-radius: 0 4px 4px 0; /* Rounded border for right edge */
        }

        .delete-room-button:hover {
            background-color: #cc0000; /* Darker red on hover */
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
            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="text-white hover:text-blue-400 bg-transparent border-none cursor-pointer">
                    Log Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Container -->
    <div class="main-container">
        <div class="main-content">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="text-right">
                        @if (auth()->user()->isAdmin())
                            <!-- Add Room Button -->
                            <a href="{{ route('rooms.create') }}" class="add-room-button">Tambah Bilik</a>
                        @endif
                    </div>
                    <div class="room-container">
                        <!-- Room Boxes -->
                        @foreach ($rooms as $room)
                            <div class="room-box" onclick="window.location='{{ route('bookings.create', $room->id) }}';">
                                <!-- Room Image -->
                                <img src="{{ $room->image_url }}" alt="{{ $room->name }}" class="room-image">
                                <!-- Room Name -->
                                <div class="room-name">{{ $room->name }}</div>
                                <!-- Link to room bookings -->
                                <span class="room-link">Tempah Sekarang</span>
                                <!-- Buttons for administrators -->
                                @if (auth()->user()->isAdmin())
                                    <div class="admin-buttons">
                                        <!-- Edit and delete buttons container -->
                                        <div class="edit-delete-container">
                                            <!-- Delete button -->
                                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-room-button">Padam</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
