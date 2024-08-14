<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display the profile of a specific user.
     *
     * @param  int  $user_id
     * @return \Illuminate\View\View
     */
    public function showProfile($user_id)
    {
        $user = User::findOrFail($user_id); // Fetch the user by ID
        return view('showprofile', compact('user')); // Pass the user data to the profile view
    }

    public function editProfile()
{
    $user = Auth::user(); // Get the currently authenticated user
    return view('editprofile', compact('user')); // Pass the user data to the profile view
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'ICnumber' => 'required|string|max:12',
        'phone_number' => 'required|string|max:15',
        'affiliation' => 'required|string|max:255',
    ]);

    $user->update($validatedData);

    return redirect()->route('showprofile', ['user_id' => $user->id])->with('success', 'Profil berjaya dikemaskini!');
}

public function listUsers()
{
    $users = User::all(); // Fetch all users
    return view('users-list', compact('users')); // Pass the users data to the users list view
}
public function deleteUser($user_id)
{
    $user = User::findOrFail($user_id); // Fetch the user by ID
    $user->delete(); // Delete the user
    return redirect()->route('users.list')->with('success', 'Pengguna berjaya dipadam!');

}

public function showAddAdminForm()
{
    return view('add-admin'); // Return the view for the add admin form
}

public function addAdmin(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'ICnumber' => 'required|string|max:12',
        'phone_number' => 'required|string|max:15',
        'affiliation' => 'required|string|max:255',
        'role' => 'required|string|in:admin,user', // Ensure the role is valid
    ]);

    // Create a new user with the validated data and 'admin' role
    $admin = User::create([
        'name' => $validatedData['name'],
        'ICnumber' => $validatedData['ICnumber'],
        'phone_number' => $validatedData['phone_number'],
        'affiliation' => $validatedData['affiliation'],
        'role' => 'admin', // Assign the role as 'admin'
    ]);

    return redirect()->route('users.list')->with('success', 'Admin berjaya ditambah!');
}


}

