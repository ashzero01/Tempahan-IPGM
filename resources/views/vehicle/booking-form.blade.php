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

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
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
            min-width: 280px; /* Ensures responsiveness */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book a Vehicle</h1>
        <form action="{{ route('bookings.search') }}" method="POST">
            @csrf
            <!-- Date and Time Selection -->
            <div class="form-row">
                <div class="form-group">
                    <label for="departure_date">Departure Date</label>
                    <input type="text" name="departure_date" id="departure_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="return_date">Return Date</label>
                    <input type="text" name="return_date" id="return_date" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="departure_time">Departure Time</label>
                    <input type="text" name="departure_time" id="departure_time" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="return_time">Return Time</label>
                    <input type="text" name="return_time" id="return_time" class="form-control">
                </div>
            </div>
            <!-- Booking Details -->
            <div class="form-group">
                <label for="destination">Destination</label>
                <input type="text" name="destination" id="destination" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose</label>
                <input type="text" name="purpose" id="purpose" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Next</button>
        </form>
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

        function formatDateWithDay(date) {
            const weekdays = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];
            const day = weekdays[date.getDay()];
            const dayFormatted = date.getDate().toString().padStart(2, '0');
            const monthFormatted = (date.getMonth() + 1).toString().padStart(2, '0');
            const yearFormatted = date.getFullYear();
            return `${dayFormatted}-${monthFormatted}-${yearFormatted} (${day})`;
        }

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
