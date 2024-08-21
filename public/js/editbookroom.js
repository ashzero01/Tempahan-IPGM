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
        const roomId = '{{ $booking->room_id }}';
        const endpoint = `{{ route('bookings.json', ['room' => $booking->room_id]) }}`;

        fetch(endpoint)
            .then(response => response.json())
            .then(bookings => {
                bookings.forEach(booking => {
                    const { date } = booking;
                    const button = document.querySelector(`button[data-date="${date}"]`);

                    if (button) {
                        button.classList.add('partial');
                    }
                });
            })
            .catch(error => console.error('Error fetching booking data:', error));
    }

    // Event listener for date button clicks
    dayButtonsContainer.addEventListener('click', function (event) {
        if (event.target.classList.contains('date-btn')) {
            dayButtonsContainer.querySelectorAll('.date-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            event.target.classList.add('active');
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
const roomId = '{{ $booking->room_id }}';
const currentBookingId = '{{ $booking->id }}'; // Get the current booking ID
const endpoint = `{{ route('bookings.json1', ['room' => $booking->room_id]) }}?date=${date}`;

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
        bookings.forEach(booking => {
            const row = document.createElement('tr');
            const startTime = formatTime(booking.start_time);
            const endTime = formatTime(booking.end_time);
            const dayOfWeek = getDayOfWeek(booking.date); // Get the day of the week
            const purpose = booking.purpose; // Fetch the purpose value from the booking object
            let viewButton = `<a href="{{ route('bookings.show', ['booking' => ':bookingId']) }}">View</a>`;
            viewButton = viewButton.replace(':bookingId', booking.id);
            let deleteButton = ''; // Initialize delete button as empty string
            if (isAdmin || booking.user_id == userId) { // Check if the user is an admin or if the booking belongs to the user
                deleteButton = `<button type="submit" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>`;
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

            // Highlight the current booking row
            if (booking.id == currentBookingId) {
                row.classList.add('highlighted-row');
            }

            tbody.appendChild(row);
        });

        bookingDetailsTable.classList.remove('hidden');
    })
    .catch(error => console.error('Error fetching booking details:', error));
}

    // Select the current booking date button on page load
    function selectCurrentBookingDate() {
        const currentBookingDate = '{{ $booking->date }}';
        const button = document.querySelector(`button[data-date="${currentBookingDate}"]`);
        if (button) {
            button.classList.add('active');
            bookingDateInput.value = currentBookingDate;
            fetchAndDisplayBookingDetails(currentBookingDate);
        }
    }

    // Call the function to select the current booking date button
    selectCurrentBookingDate();
});
