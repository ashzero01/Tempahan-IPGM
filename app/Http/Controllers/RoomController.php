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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate multiple images
        ]);
    
        $imagePaths = [];
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move(storage_path('app/public/images'), $imageName);
                $imagePaths[] = 'images/' . $imageName;
            }
        }
    
        $data['images'] = json_encode($imagePaths); // Convert array to JSON
    
        Room::create($data);
    
        return response()->json(['message' => 'Room created successfully'], 200);
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
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate multiple images
    ]);

    $imagePaths = json_decode($room->images, true) ?? []; // Existing images

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePaths[] = 'images/' . $imageName;
        }
    }

    $data['images'] = json_encode($imagePaths); // Update with new images

    $room->update($data);

    return redirect()->route('rooms.index');
}

public function filter($description)
{
    $rooms = Room::where('description', $description)->get(); // Adjust this based on your room model structure

    return view('rooms.index', compact('rooms'));
}

}
