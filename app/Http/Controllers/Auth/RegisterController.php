<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'FirstName'       => ['required', 'string', 'max:255'],
            'LastName'        => ['required', 'string', 'max:255'],
            'MiddleName'      => ['nullable', 'string', 'max:255'],
            'extension_name'  => ['nullable', 'string', 'max:255'],
            'contact'         => ['nullable','digits:11'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'        => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'FirstName'      => $validated['FirstName'],
            'LastName'       => $validated['LastName'],
            'MiddleName'     => $validated['MiddleName'] ?? null,
            'extension_name' => $validated['extension_name'] ?? null,
            'contact'        => $validated['contact'] ?? null,
            'email'          => $validated['email'],
            'password'       => Hash::make($validated['password']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect('/waiting');
    } 
}
