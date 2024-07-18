<!-- resources/views/bookings/view.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        <p>Room: {{ $room->name }}</p>
                        <p>Date: {{ $booking->date }}</p>
                        <p>Start Time: {{ $booking->start_time }}</p>
                        <p>End Time: {{ $booking->end_time }}</p>
                        <p>Purpose: {{ $booking->purpose }}</p>
<!-- Example of accessing user data -->
<p>User Name: {{ $booking->user->name }}</p>
<p>User Email: {{ $booking->user->email }}</p>
<p>User Phone Number: {{ $booking->user->phone_number }}</p>
<p>User Affiliation: {{ $booking->user->affiliation }}</p>

<div class="mt-8">
                        <a href="{{ route('bookings.edit', ['booking' => $booking->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
