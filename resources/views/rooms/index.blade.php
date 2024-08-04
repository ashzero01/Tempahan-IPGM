<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bilik') }}
        </h2>
    </x-slot>

    <style>
        /* Style for the box container */
        .room-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        /* Style for the room box */
        .room-box {
            width: calc(33.33% - 20px); /* Adjust the width as needed */
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s ease;
            cursor: pointer; /* Add cursor pointer */
        }

        .room-box:hover {
            transform: translateY(-5px);
        }

        /* Style for the room image */
        .room-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        /* Style for the room name */
        .room-name {
            font-size: 18px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 10px;
        }

        /* Style for the room link */
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



</x-app-layout>
