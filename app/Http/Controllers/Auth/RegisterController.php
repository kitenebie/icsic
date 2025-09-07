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
    private function saveBase64Image($base64Data, $folder)
    {
        // Remove the data:image/png;base64, part
        $imageData = str_replace('data:image/png;base64,', '', $base64Data);
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = str_replace('data:image/jpg;base64,', '', $imageData);
        $imageData = str_replace('data:image/gif;base64,', '', $imageData);

        // Decode the base64 data
        $decodedData = base64_decode($imageData);

        // Generate a unique filename
        $filename = 'profile_' . time() . '_' . uniqid() . '.png';

        // Save the file to storage/app/public/$folder
        $path = storage_path('app/public/' . $folder);
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . '/' . $filename, $decodedData);

        // Return the relative path for database storage
        return $folder . '/' . $filename;
    }


public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'FirstName'       => ['required', 'string', 'max:255'],
            'LastName'        => ['required', 'string', 'max:255'],
            'MiddleName'      => ['nullable', 'string', 'max:255'],
            'extension_name'  => ['nullable', 'string', 'max:255'],
            'contact'         => ['nullable','digits:11'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'front_id'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'back_id'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'manual_profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'profile_image_data' => ['nullable', 'string'],
            'profile_picture' => ['nullable', 'string'],
        ]);


        $frontIdPath = null;
        $backIdPath = null;

        if ($request->hasFile('front_id')) {
            $frontIdPath = $request->file('front_id')->store('ids', 'public');
        }

        if ($request->hasFile('back_id')) {
            $backIdPath = $request->file('back_id')->store('ids', 'public');
        }

        $profileImagePath = null;
        if ($request->has('profile_image_data') && !empty($request->profile_image_data)) {
            $profileImagePath = $this->saveBase64Image($request->profile_image_data, 'profiles');
        } elseif ($request->hasFile('manual_profile_image')) {
            $profileImagePath = $request->file('manual_profile_image')->store('profiles', 'public');
        }


        $user = User::create([
            'FirstName'      => $validated['FirstName'],
            'LastName'       => $validated['LastName'],
            'MiddleName'     => $validated['MiddleName'] ?? null,
            'extension_name' => $validated['extension_name'] ?? null,
            'contact'        => $validated['contact'] ?? null,
            'email'          => $validated['email'],
            'password'       => Hash::make(str()->random(16)),
            'front_id'       => $frontIdPath,
            'back_id'        => $backIdPath,
            'profile_image'  => $profileImagePath,
            'profile_picture'  => $profileImagePath,
        ]);
        if ($user) {
            event(new Registered($user));
            Auth::login($user);
            
            // dd(Auth::user());
            return redirect('/waiting')->with('status', '✅ Account created successfully!');
        }

        return back()->with('status', '❌ Failed to create account, please try again.');

    } catch (\Exception $e) {
        return back()->with('status', '❌ Error: ' . $e->getMessage());
    }
}


}
