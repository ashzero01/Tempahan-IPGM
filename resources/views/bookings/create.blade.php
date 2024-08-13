
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Sistem Tempahan IPGMKKB</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">

    <style>
      
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
            width: 100%;
        }

        .form-container,
        .table-container {
            width: 50%;
        }

        .form-container {
            margin-right: 10px;
        }

        .table-container {
            overflow-y: auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="time"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .text-red-500 {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }

      .booking-button {
        background-color: #3490dc;
    color: white;
    font-weight: bold;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 20px; /* Adjust this value to add space above the button */
    margin-bottom: 20px; /* Adjust this value to add space below the button */
    padding: 10px 20px; /* Adjust padding as needed */
    /* Add any other styles you want to customize */
}
    .booking-button:hover {
        background-color: #2779bd;
    }
        


        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert li {
            margin-bottom: 5px;
        }

        .alert.alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .date-btn {
            width: 50px;
            height: 50px;
            margin: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .date-btn.active {
            background-color: #4a90e2;
            color: white;
            font-weight: bold;
        }

        .date-btn.partial.active {
            background-color: #4a90e2;
            color: white;
            font-weight: bold;
        }

        .date-btn.partial {
            background-color: #FFFF99;
        }

        #bookingDetails {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #bookingDetails th,
        #bookingDetails td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        #bookingDetails th {
            background-color: #f2f2f2;
        }

        #bookingDetails tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #bookingDetails tbody tr:hover {
            background-color: #ddd;
        }

        .back-button {
            background-color: transparent;
            border: none;
            color: black;
            font-size: 40px;
            cursor: pointer;
            border-radius: 12px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .back-button:hover {
            color: red;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
 
            min-height: 100vh; /* Ensure the body takes up full viewport height */
            display: flex;
            flex-direction: column; /* Stack header and main content vertically */
        }


        .main-container {
            flex: 1; /* Take up remaining space */
            display: flex;
            flex-direction: column; /* Stack content vertically */
            align-items: center; /* Center content horizontally */
        }

        .main-content {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
            padding: 10px; /* Adjust padding */
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 1500px; /* Set a maximum width */
            width: 100%; /* Ensure it takes up the full width available */
            box-sizing: border-box; /* Ensure padding and border are included in the width and height */
            margin-top: 2rem; /* Adjust this value as needed */

        }

        .text-2xl {
    display: flex;
    justify-content: space-between; /* Distribute space between the text and button */
    align-items: center; /* Align items vertically */
    width: 100%; /* Ensure the container takes full width */
}

.back-button {
    background-color: transparent;
    border: none;
    color: black;
    font-size: 40px;
    cursor: pointer;
    border-radius: 12px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.back-button:hover {
    color: red;
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
        <a>{{ auth()->user()->name }}</a>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">
                    Log Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Breadcrumb Section -->
<div class="breadcrumb">
<a href="{{ route('dashboard') }}">Halaman Utama</a>
    <span>&gt;</span> 
    <a href="/rooms">Senarai Bilik dan Dewan</a>
    <span>&gt;</span>
    <a href="#">Proses Tempahan</a>

</div>


    <div class="main-container">
    <div class="main-content">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="text-2xl flex justify-between items-center">
            <h2>Tempah   {{ $room->name }}</h2>
</div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="mt-4">
                    <div class="container">
                        <div class="form-container">
                            <form action="{{ route('bookings.store', ['room' => $room->id]) }}" method="POST">
                                @csrf
                                <div>
                                    <label>Tarikh Tempahan:</label>
                                    <div>
                                        <select id="yearSelect" name="year"></select>
                                        <select id="monthSelect" name="month"></select>
                                        <div id="dayButtons"></div>
                                    </div>
                                    <input type="hidden" id="booking_date" name="date">
                                    @error('date')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="margin-top: 10px;display: flex; align-items: center;">
                                    <label for="start_time">Masa:</label>
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <input type="time" id="start_time" name="start_time" style="margin-right: 10px;" required>
                                    <span>sehingga</span>
                                    <input type="time" id="end_time" name="end_time" style="margin-left: 10px;" required>
                                    @error('start_time')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                    @error('end_time')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="purpose">Tujuan:</label>
                                    <input type="text" id="purpose" name="purpose" required>
                                </div>
                                <button type="submit" class="booking-button">Book Room</button>
                            </form>
                            <!-- Display validation errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-4">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="table-container">
                            <table id="bookingDetails">
                                <thead>
                                <tr>
                                    <th>Tarikh</th>
                                    <th>Hari</th>
                                    <th>Masa Mula</th>
                                    <th>Masa Tamat</th>
                                    <th>Tujuan</th>
                                    <th>Status</th>
                                    <th>Tindakan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Table rows will be dynamically added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>


    <script>

function formatTime(time) {
        const [hours, minutes] = time.split(':');
        const period = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = (hours % 12) || 12;
        return `${formattedHours}:${minutes} ${period}`;
    }
    document.addEventListener('DOMContentLoaded', function () {
        const yearSelect = document.getElementById('yearSelect');
        const monthSelect = document.getElementById('monthSelect');
        const dayButtonsContainer = document.getElementById('dayButtons');
        const bookingDateInput = document.getElementById('booking_date');
        const bookingDetailsTable = document.getElementById('bookingDetails');

        // Function to fetch booking data from the server
        function fetchBookingData() {
    const roomId = '{{ $room->id }}';
    const endpoint = `{{ route('bookings.json', ['room' => $room->id]) }}`;

    fetch(endpoint)
        .then(response => response.json())
        .then(bookings => {
            bookings.forEach(booking => {
                if (booking.type === 'rooms') { // Filter by type 'rooms'
                    const { date } = booking;
                    const button = document.querySelector(`button[data-date="${date}"]`);

                    if (button) {
                        button.classList.add('partial');
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching booking data:', error));
}


        // Event listener for date button clicks
        dayButtonsContainer.addEventListener('click', function (event) {

            if (event.target.classList.contains('date-btn')) {
                // Remove active class from all buttons
                dayButtonsContainer.querySelectorAll('.date-btn').forEach(btn => {
                    btn.classList.remove('active');
                });

                event.target.classList.add('active');

                // Add active class to the clicked button
                    
                const selectedDate = event.target.getAttribute('data-date');
                bookingDateInput.value = selectedDate;

                // Fetch and display booking details for the selected date
                fetchAndDisplayBookingDetails(selectedDate);
                
            }
            
            
        });
        function getDayOfWeek(dateString) {
        const daysOfWeek = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];
        const date = new Date(dateString);
        const dayOfWeekIndex = date.getDay();
        return daysOfWeek[dayOfWeekIndex];
    }

        // Populate year select options
        const startYear = 2000;
        const endYear = new Date().getFullYear() + 10;
        for (let year = startYear; year <= endYear; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }
        yearSelect.value = new Date().getFullYear();

        const customMonthNames = [
    'Januari', 'Februari', 'Mac', 'April', 'Mei', 
    'Jun','Julai', 'Ogos', 'September',
     'Oktober', 'November', 'Disember'];

        // Populate month select options
        for (let month = 1; month <= 12; month++) {
            const option = document.createElement('option');
            option.value = month;
            option.textContent = customMonthNames[month - 1];
            monthSelect.appendChild(option);
        }
        monthSelect.value = new Date().getMonth() + 1;

        // Function to generate day buttons for a given year and month
        function generateDayButtons(year, month) {
            dayButtonsContainer.innerHTML = '';
            const daysInMonth = new Date(year, month, 0).getDate();

            for (let day = 1; day <= daysInMonth; day++) {
                const button = document.createElement('button');
                button.type = 'button';
                button.classList.add('date-btn');
                button.textContent = day;
                button.setAttribute('data-date', `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`);
                dayButtonsContainer.appendChild(button);
            }

            // Fetch booking data after generating day buttons
            fetchBookingData();
        }

        // Generate day buttons for the current year and month by default
        generateDayButtons(new Date().getFullYear(), new Date().getMonth() + 1);

        // Event listeners for year and month changes
        yearSelect.addEventListener('change', function () {
            generateDayButtons(parseInt(this.value), parseInt(monthSelect.value));
        });

        monthSelect.addEventListener('change', function () {
            generateDayButtons(parseInt(yearSelect.value), parseInt(this.value));
        });

        // Function to fetch and display booking details for a specific date
        function fetchAndDisplayBookingDetails(date) {
    const roomId = '{{ $room->id }}';
    const endpoint = `{{ route('bookings.json1', ['room' => $room->id]) }}?date=${date}`;

    fetch(endpoint)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(bookings => {
            const tbody = bookingDetailsTable.querySelector('tbody');
            tbody.innerHTML = '';
            const userId = '{{ auth()->id() }}'; // Get the ID of the authenticated user
            const isAdmin = '{{ auth()->user()->isAdmin() }}'; // Check if the authenticated user is an admin

            // Filter bookings to include only those with type "rooms"
            const filteredBookings = bookings.filter(booking => booking.type === 'rooms');

            filteredBookings.forEach(booking => {
                const row = document.createElement('tr');
                const startTime = formatTime(booking.start_time);
                const endTime = formatTime(booking.end_time);
                const dayOfWeek = getDayOfWeek(booking.date); // Get the day of the week
                const purpose = booking.purpose; // Fetch the purpose value from the booking object
                let viewButton = `<a href="{{ route('bookings.show', ['booking' => ':bookingId']) }}">View</a>`;
                viewButton = viewButton.replace(':bookingId', booking.id);
                let deleteButton = ''; // Initialize delete button as empty string
                if (isAdmin || booking.user_id == userId) { // Check if the user is an admin or if the booking belongs to the user
                    deleteButton = `<button type="submit" onclick="return confirm('Anda pasti untuk padamkan tempahan ini?')">Delete</button>`;
                }
                row.innerHTML = `
                    <td>${booking.date}</td>
                    <td>${dayOfWeek}</td> <!-- Display the day of the week -->
                    <td>${startTime}</td>
                    <td>${endTime}</td>
                    <td>${purpose}</td>
                    <td>${booking.status}</td> <!-- Display the status -->

                    <td>
                    ${viewButton}
                        <form action="{{ route('bookings.destroy', ['room' => $room->id, 'booking' => ':bookingId']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            ${deleteButton} <!-- Include delete button based on condition -->
                        </form>
                    </td>
                `;
                row.querySelector('form').action = row.querySelector('form').action.replace(':bookingId', booking.id);
                tbody.appendChild(row);
            });

            bookingDetailsTable.classList.remove('hidden');
        })
        .catch(error => console.error('Error fetching booking details:', error));
}

    });
</script>
