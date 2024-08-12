<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    // Show the list of vehicles
    public function index()
    {
        $vehicles = Vehicle::all(); // Retrieve all vehicles from the database
        return view('vehicle.index', compact('vehicles')); // Pass vehicles to the view
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
            'status' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully!');
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

        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully!');
    }

    public function showSelect(){
        {
            $vehicles = Vehicle::all(); // Retrieve all vehicles from the database
            return view('vehicle.vehicle-show', compact('vehicles')); // Pass vehicles to the view
        }
    }
}
