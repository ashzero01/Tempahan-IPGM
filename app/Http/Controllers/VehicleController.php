<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

    class VehicleController extends Controller
    {
        public function index()
    {
        $vehicles = Vehicle::all();
        return view('vehicle', compact('vehicles'));
    }


    // Show the form to create a new vehicle
    public function create()
    {
        return view('vehicle.create');
    }

    // Store a newly created vehicle in the database
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'registration_number' => 'required|string|unique:vehicles|max:255',
        'type' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'status' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $validated['image'] = 'images/' . $imageName;
    }

    Vehicle::create($validated);

    return redirect()->route('vehicles.book')->with('success', 'Vehicle created successfully!');
}

    // Show the form to edit a specific vehicle
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicle.edit', compact('vehicle'));
    }

    // Update a specific vehicle in the database
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:vehicles,registration_number,' . $id . '|max:255',
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully!');
    }

    // Delete a specific vehicle from the database
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('vehicles.book')->with('success', 'Vehicle deleted successfully!');
    }

    public function book()
{
    $vehicles = Vehicle::all();
    return view('vehicle.book', compact('vehicles'));
}

public function showEditImage($id)
{
    $vehicle = Vehicle::findOrFail($id);
    return view('vehicle.editimage', compact('vehicle'));
}
public function updateImage(Request $request, $id)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $vehicle = Vehicle::findOrFail($id);

    if ($request->hasFile('image')) {

        // Upload the new image
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $vehicle->update(['image' => 'images/' . $imageName]);
    }

    return redirect()->route('vehicles.book')->with('success', 'Vehicle image updated successfully!');
}


}
