<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserLoginController extends Controller
{
    /**
     * Handle an incoming login request.
     */
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'ICnumber' => ['required', 'exists:users,ICnumber'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the user by IC number
        $user = User::where('ICnumber', $request->ICnumber)->first();

        if ($user) {
            // Log the user in
            Auth::login($user);
            return redirect()->intended('/dashboard'); // Redirect to the desired route
        }

        // If no user found, redirect back with an error
        return redirect()->back()->withErrors(['ICnumber' => 'Invalid IC number.']);
    }
}
