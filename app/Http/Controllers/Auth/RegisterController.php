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

    private function compareImages($image1Path, $image2Path)
    {
        // Simple image comparison using image dimensions and basic pixel comparison
        if (!file_exists($image1Path) || !file_exists($image2Path)) {
            return false;
        }

        $img1 = imagecreatefromstring(file_get_contents($image1Path));
        $img2 = imagecreatefromstring(file_get_contents($image2Path));

        if (!$img1 || !$img2) {
            return false;
        }

        $width1 = imagesx($img1);
        $height1 = imagesy($img1);
        $width2 = imagesx($img2);
        $height2 = imagesy($img2);

        // If dimensions are too different, they're not the same
        if (abs($width1 - $width2) > 50 || abs($height1 - $height2) > 50) {
            return false;
        }

        // Resize both images to same size for comparison
        $size = 100;
        $resized1 = imagecreatetruecolor($size, $size);
        $resized2 = imagecreatetruecolor($size, $size);

        imagecopyresampled($resized1, $img1, 0, 0, 0, 0, $size, $size, $width1, $height1);
        imagecopyresampled($resized2, $img2, 0, 0, 0, 0, $size, $size, $width2, $height2);

        // Compare pixel by pixel
        $difference = 0;
        $totalPixels = $size * $size;

        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $rgb1 = imagecolorat($resized1, $x, $y);
                $rgb2 = imagecolorat($resized2, $x, $y);

                $r1 = ($rgb1 >> 16) & 0xFF;
                $g1 = ($rgb1 >> 8) & 0xFF;
                $b1 = $rgb1 & 0xFF;

                $r2 = ($rgb2 >> 16) & 0xFF;
                $g2 = ($rgb2 >> 8) & 0xFF;
                $b2 = $rgb2 & 0xFF;

                $difference += abs($r1 - $r2) + abs($g1 - $g2) + abs($b1 - $b2);
            }
        }

        $averageDifference = $difference / ($totalPixels * 3 * 255);

        // If difference is less than 10%, consider them similar
        return $averageDifference < 0.1;
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
            'profile_image_data' => ['nullable', 'string'],
        ]);

        // Custom validation: if profile image is provided, at least one ID must be uploaded
        if (!empty($request->profile_image_data)) {
            if (!$request->hasFile('front_id') && !$request->hasFile('back_id')) {
                return back()->withErrors(['id_required' => 'At least one ID (front or back) must be uploaded when providing a profile picture.']);
            }
        }

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

            // Compare profile image with ID images
            $profileImageFullPath = storage_path('app/public/' . $profileImagePath);
            $similarToId = false;

            if ($request->hasFile('front_id')) {
                $frontIdTempPath = $request->file('front_id')->getRealPath();
                if ($this->compareImages($profileImageFullPath, $frontIdTempPath)) {
                    $similarToId = true;
                }
            }

            if ($request->hasFile('back_id') && !$similarToId) {
                $backIdTempPath = $request->file('back_id')->getRealPath();
                if ($this->compareImages($profileImageFullPath, $backIdTempPath)) {
                    $similarToId = true;
                }
            }

            if (!$similarToId) {
                return back()->withErrors(['image_match' => 'The profile picture must match one of the uploaded ID images.']);
            }
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
