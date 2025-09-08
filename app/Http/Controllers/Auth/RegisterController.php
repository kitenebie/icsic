<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /**
     * METHOD 1: Direct File Storage (Fastest)
     * Skip base64 conversion entirely - directly store uploaded files
     */
    private function storeImageDirect($file, $folder)
    {
        // Generate unique filename
        $filename = 'profile_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store directly using Laravel's storage
        $path = $file->storeAs($folder, $filename, 'public');
        
        return $path;
    }

    /**
     * METHOD 2: Optimized Base64 with Compression (Current method improved)
     * For when you must use base64 (camera capture)
     */
    private function saveBase64ImageOptimized($base64Data, $folder, $quality = 85)
    {
        // Remove data URL prefix more efficiently
        $imageData = preg_replace('/^data:image\/[^;]+;base64,/', '', $base64Data);
        
        // Decode
        $decodedData = base64_decode($imageData);
        if ($decodedData === false) {
            throw new \InvalidArgumentException('Invalid base64 image data');
        }
        
        // Generate filename
        $filename = 'profile_' . time() . '_' . uniqid() . '.jpg'; // Always use JPG for smaller size
        
        // Use Intervention Image for compression and optimization
        $image = Image::make($decodedData);
        
        // Optimize: resize if too large, compress
        $image->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize(); // Don't upsize smaller images
        });
        
        // Save compressed image
        $path = storage_path('app/public/' . $folder);
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        
        $image->save($path . '/' . $filename, $quality);
        
        return $folder . '/' . $filename;
    }

    /**
     * METHOD 3: Stream-based Storage (Memory Efficient)
     * Best for large images
     */
    private function saveBase64ImageStream($base64Data, $folder)
    {
        // Remove prefix
        $imageData = preg_replace('/^data:image\/[^;]+;base64,/', '', $base64Data);
        
        // Generate filename
        $filename = 'profile_' . time() . '_' . uniqid() . '.jpg';
        $fullPath = $folder . '/' . $filename;
        
        // Use Laravel Storage for streaming
        $stream = fopen('php://temp', 'w+');
        fwrite($stream, base64_decode($imageData));
        rewind($stream);
        
        Storage::disk('public')->writeStream($fullPath, $stream);
        fclose($stream);
        
        return $fullPath;
    }

    /**
     * METHOD 4: Queue-based Async Processing (Fastest Response)
     * Move heavy processing to background
     */
    private function saveBase64ImageAsync($base64Data, $folder)
    {
        // Store temporarily with minimal processing
        $tempFilename = 'temp_' . time() . '_' . uniqid() . '.tmp';
        $tempPath = storage_path('app/temp/' . $tempFilename);
        
        if (!is_dir(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }
        
        // Just decode and save temporarily
        file_put_contents($tempPath, base64_decode(preg_replace('/^data:image\/[^;]+;base64,/', '', $base64Data)));
        
        // Queue the optimization job
        \App\Jobs\ProcessImageUpload::dispatch($tempPath, $folder);
        
        // Return temporary path (will be replaced by job)
        return 'temp/' . $tempFilename;
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

            // OPTIMIZED IMAGE PROCESSING
            $frontIdPath = null;
            $backIdPath = null;
            $profileImagePath = null;

            // Process ID uploads with direct storage (fastest)
            if ($request->hasFile('front_id')) {
                $frontIdPath = $this->storeImageDirect($request->file('front_id'), 'ids');
            }

            if ($request->hasFile('back_id')) {
                $backIdPath = $this->storeImageDirect($request->file('back_id'), 'ids');
            }

            // Process profile image based on source
            if ($request->has('profile_image_data') && !empty($request->profile_image_data)) {
                // Camera capture - use optimized base64 method
                $profileImagePath = $this->saveBase64ImageOptimized($request->profile_image_data, 'profiles', 80);
            } elseif ($request->hasFile('manual_profile_image')) {
                // Manual upload - use direct storage
                $profileImagePath = $this->storeImageDirect($request->file('manual_profile_image'), 'profiles');
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
                'profile_picture' => $profileImagePath,
            ]);

            if ($user) {
                event(new Registered($user));
                Auth::login($user);
                
                return redirect('/waiting')->with('status', '✅ Account created successfully!');
            }

            return back()->with('status', '❌ Failed to create account, please try again.');

        } catch (\Exception $e) {
            return back()->with('status', '❌ Error: ' . $e->getMessage());
        }
    }
}