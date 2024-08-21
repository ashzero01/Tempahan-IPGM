<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;

use Illuminate\Http\Request;

class RoomController extends Controller
{

    
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {

     
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate the image upload
        ]);



        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            // Save the image path in the database as 'images/filename'
            $data['image'] = 'images/' . $imageName;
        }
        

        Room::create($data);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index');
    }

    public function edit(Room $room)
    {
        // You should return a view for editing the room here
        return view('rooms.edit', compact('room'));
    }
    public function update(Request $request, Room $room)
{
    $data = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate the image upload
    ]);



    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;
    } else {
        // If no new image is uploaded, retain the existing image
        $data['image'] = $room->image;
    }

    $room->update($data);

    return redirect()->route('rooms.index');
}

public function filter($description)
{
    $rooms = Room::where('description', $description)->get(); // Adjust this based on your room model structure

    return view('rooms.index', compact('rooms'));
}

}