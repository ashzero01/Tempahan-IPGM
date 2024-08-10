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
        'email' => 'required|email|max:255',
        'ICnumber' => 'required|string|max:12',
        'phone_number' => 'required|string|max:15',
        'affiliation' => 'required|string|max:255',
    ]);

    $user->update($validatedData);

    return redirect()->route('showprofile', ['user_id' => $user->id])->with('success', 'Profil berjaya dikemaskini!');
}

}

