<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom Styling for Square Buttons */
        .custom-button {
            width: 500px; /* Set width to ensure square shape */
            height: 500px; /* Set height to ensure square shape */
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            text-align: center;
            color: white;
            font-size: 80px;
        }

        .custom-button:hover {
            transform: translateY(-5px);
        }

        .bg-blue-custom {
            background-color: #1d4ed8; /* Blue color */
        }

        .bg-green-custom {
            background-color: #10b981; /* Green color */
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <!-- Buttons Container -->
                    <div class="flex justify-center gap-4">
                        <!-- Tempah Bilik Button -->
                        <a href="{{ route('rooms.index') }}" class="custom-button bg-blue-custom">
                            Tempah Bilik
                        </a>
                        <!-- Tempah Kenderaan Button -->
                        <a href="{{ route('bookings.user', ['user_id' => auth()->id()]) }}" class="custom-button bg-green-custom">
                            Tempah Kenderaan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>
</html>
