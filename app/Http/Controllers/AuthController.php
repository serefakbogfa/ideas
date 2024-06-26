<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\TestEmail;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Contracts\Service\Attribute\Required;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store()
    {
        $validated = request()->validate(

            [
                'name' => 'required|min:5|max:40',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8',
            ]
        );

        $user = User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );
           Mail::to($user->email)
           ->send(new TestEmail($user));

        return redirect()->route('dashboard')->with('success', 'Accout created successfully');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate()
    {
        $validated = request()->validate(

            [

                'email' => 'required|email',
                'password' => 'required|min:8',
            ]
        );

        if (auth()->attempt($validated)) {
            request()->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login created successfully');
            # code...
        }
        return redirect()->route('login')->withErrors([
            'email' => "No matching user found with provided email and password"
        ]);
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerate();
        return redirect()->route('dashboard')->with('success', 'Logout successfully');
    }
}