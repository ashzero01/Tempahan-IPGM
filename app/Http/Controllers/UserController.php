<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}

