<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // Ensure this view exists
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Check if this is the first user
        $isFirstUser = User::count() === 0;

        // Create the user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'ICnumber' => $request->input('ICnumber'),
            'phone_number' => $request->input('phone_number'),
            'affiliation' => $request->input('affiliation'),
            'password' => $isFirstUser ? Hash::make('default_password') : null, // Optional: Set a default password for the first user
            'role' => $isFirstUser ? 'admin' : 'user',
        ]);

        // Optionally log the user in
        auth()->login($user);

        return redirect()->route('dashboard'); // Adjust as needed
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'ICnumber' => ['required', 'string', 'max:255', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'affiliation' => ['nullable', 'string', 'max:255'],
            // No need for password validation since it's optional
        ]);
    }
}
