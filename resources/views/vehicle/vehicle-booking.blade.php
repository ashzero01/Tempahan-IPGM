<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Booking</title>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backbutton.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.6.0-web/css/all.min.css') }}">

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
            font-size: 1.5rem;
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

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Error Message Styling */
        #error-message {
            color: red;
            display: none;
            margin-top: 10px;
        }

        /* Success Message Styling */
        #success-message {
            color: green;
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Main Content Section -->
    <div class="main-container">
        <div class="page-title">
            <h1>Tempah Kenderaan</h1>
        </div>
        <div class="container">
            <form id="vehicle-booking-form" method="POST" action="{{ route('checkVehicle') }}">
                @csrf
                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                <!-- Date and Time Selection -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="departure_date">Tarikh Pergi</label>
                        <input type="text" name="departure_date" id="departure_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="return_date">Tarikh Balik (Jika Ada)</label>
                        <input type="text" name="return_date" id="return_date" class="form-control">
                    </div>
                </div>

                <div class="button-container">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Lanjut</button>
                </div>
                <div id="error-message"></div>
                <div id="success-message"></div>
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
                shorthand: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis'],
                longhand: ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember']
            },
            rangeSeparator: ' hingga ',
            time_24hr: true
        });

        flatpickr("#departure_date", {
            dateFormat: "d-m-Y",
            minDate: "today"
        });

        flatpickr("#return_date", {
            dateFormat: "d-m-Y",
            minDate: "today"
        });

        // Display success message based on URL parameter
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        window.onload = function() {
            const successMessage = getUrlParameter('success');
            if (successMessage === 'true') {
                document.getElementById('success-message').innerText = 'Your booking was successful!';
                document.getElementById('success-message').style.display = 'block';
            }
        };
    </script>
</body>
</html>
