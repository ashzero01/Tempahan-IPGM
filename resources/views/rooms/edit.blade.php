<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms') }}
        </h2>
    </x-slot>

    <style>
        .create-room-button {
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
            padding: 10px 20px;
        }

        .create-room-button:hover {
            background-color: #357bd8;
        }

        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .form-fields {
            width: 100%;
        }

        /* Style for the image preview box */
        #image-preview-container {
            width: calc(33.33% - 20px); /* Same width as room-box */
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Style for the image preview */
        #preview {
            width: 100%;
            height: auto;
            border-radius: 8px; /* Match border-radius of room-box */
            max-width: 100%; /* Ensure image does not exceed container width */
            max-height: 300px; /* Set maximum height for the image */
        }

        .file-input {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ffffff;
            color: #4a90e2;
            border: 2px solid #4a90e2;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .file-input:hover {
            background-color: #357bd8;
        }

        /* Hide the default file input */
        #image {
            display: none;
        }
    </style>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="text-2xl">
                        Edit Room
                    </div>
                    <!-- Room Form -->
                    <div class="mt-4 form-container">
                        <div class="form-fields">
                        <form id="room-form" action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <!-- Room Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Room Name</label>
                                    <input type="text" name="name" id="name" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ $room->name }}">
                                    @error('name')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" name="description" id="description" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ $room->description }}">
                                    @error('description')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Image Upload -->
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                    <label for="image" class="file-input">Choose File</label>
                                    <input type="file" name="image" id="image" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" onchange="previewImage(event)">
                                    @error('image')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <!-- Message Area for Success or Error -->
                                <div id="message-area" class="mt-4"></div>

                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="button" class="create-room-button" onclick="submitForm()">Update Room</button>
                                </div>
                            </form>
                        </div>
                        <!-- Image Preview -->
                        <div id="image-preview-container" class="form-image">
                            <img id="preview" class="rounded-md">
                        </div>
                    </div>
                </div>
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
                    previewContainer.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                previewContainer.style.display = 'none';
            }
        }

function submitForm() {
    var roomForm = document.getElementById('room-form');
    var formData = new FormData(roomForm);
    var imageFile = document.getElementById('image').files[0];
    formData.append('image', imageFile);

    // Extract the room ID from the form action URL
    var roomId = roomForm.action.split('/').pop();
console.log(roomId);

    // Construct the URL for updating the room
    var updateUrl = "{{ url('rooms') }}/" + roomId + "/edit";


    
    // Send form data to the server using a PUT request
    fetch(updateUrl, {
        method: 'PUT',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            // If response is not OK, throw an error
            throw new Error('Network response was not ok');
        }
        // If response is OK, return the JSON data
        return response.json();
    })
    .then(data => {
        // Handle the JSON data
        // For example, display a success message
        var messageArea = document.getElementById('message-area');
        messageArea.innerHTML = `<div class="text-green-500">${data.message}</div>`;
        // Optionally, you can redirect to the index page or perform other actions
        window.location.href = roomsIndexRoute;
    })
    .catch(error => {
        // Handle error
        console.error('Error:', error);
        // Display error message
        var messageArea = document.getElementById('message-area');
        messageArea.innerHTML = `<div class="text-red-500">An error occurred while updating the room.</div>`;
    });
}


        // JavaScript for displaying existing image
        window.onload = function() {
            var existingImageUrl = '{{ asset("images/" . $room->image) }}'; // Get the existing image URL
            if (existingImageUrl) {
                var preview = document.getElementById('preview');
                var previewContainer = document.getElementById('image-preview-container');
                preview.src = existingImageUrl;
                previewContainer.style.display = 'block';
            }
        };
    </script>
</x-app-layout>