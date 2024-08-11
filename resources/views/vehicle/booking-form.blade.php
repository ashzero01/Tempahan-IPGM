<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date and Time Picker Example</title>
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f4f4f9;
        }

        /* Main Content Styling */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Center Button Container */
        .page-title {
    padding: 1.5rem;
    font-size: 1.5rem; /* Adjust font size */
    color: #333333;
    border-bottom: 2px solid #E5E7EB;
}

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 280px;
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
            <a>{{ auth()->user()->name }}</a>
            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">Log Keluar</button>
            </form>
        </div>
    </header>
    <!-- End of Header Section -->

    <!-- Main Content Section -->
    <div class="main-container">
        <div class="page-title">
            <h1>Tempah Kenderaan</h1>
        </div>
        <div class="container">
            <form action="{{ route('bookings.search') }}" method="POST">
                @csrf
                <!-- Date and Time Selection -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="departure_date">Tarikh Pergi</label>
                        <input type="text" name="departure_date" id="departure_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="return_date">Tarikh Balik</label>
                        <input type="text" name="return_date" id="return_date" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="departure_time">Waktu Berlepas</label>
                        <input type="text" name="departure_time" id="departure_time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="return_time">Waktu Pulang</label>
                        <input type="text" name="return_time" id="return_time" class="form-control">
                    </div>
                </div>
                <!-- Booking Details -->
                <div class="form-group">
                    <label for="destination">Destinasi</label>
                    <input type="text" name="destination" id="destination" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="purpose">Tujuan</label>
                    <input type="text" name="purpose" id="purpose" class="form-control" required>
                </div>
                
                <div class="button-container">
                <a href="{{ route('bookings.booking-form') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Lanjut</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        flatpickr.localize({
            weekdays: {
                shorthand: ['Ahad', 'Isn', 'Sel', 'Rab', 'Kha', 'Jum', 'Sab'],
                longhand: ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu']
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis'],
                longhand: ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember']
            }
        });

        $(document).ready(function() {
            flatpickr("#departure_date", {
                dateFormat: "d-m-Y",
                minDate: "today"
            });

            flatpickr("#departure_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // 24-hour format
                minuteIncrement: 30
            });

            flatpickr("#return_date", {
                dateFormat: "d-m-Y",
                minDate: "today"
            });

            flatpickr("#return_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // 24-hour format
                minuteIncrement: 30
            });
        });
    </script>
</body>
</html>
