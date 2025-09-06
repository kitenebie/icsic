<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Modal extends Component
{
    use WithFileUploads;

    public $first_name;
    public $middle_name;
    public $last_name;
    public $extension_name;
    public $email;
    public $password;
    public $confirm_password;
    public $profile;

    public function mount()
    {
        $user = Auth::user();
        $this->first_name = $user->FirstName;
        $this->middle_name = $user->MiddleName;
        $this->last_name = $user->LastName;
        $this->extension_name = $user->extension_name;
        $this->email = $user->email;
    }

    public function updatedProfile()
    {
        $this->validate([
            'profile' => 'image|max:2048', // 2MB max
        ]);

        // Store file in localStorage for persistence
        if ($this->profile) {
            $this->storeFileInLocalStorage();
        }
    }

    private function storeFileInLocalStorage()
    {
        if ($this->profile) {
            // Convert file to base64 for localStorage
            $fileData = base64_encode(file_get_contents($this->profile->getRealPath()));
            $fileInfo = [
                'name' => $this->profile->getClientOriginalName(),
                'size' => $this->profile->getSize(),
                'mime' => $this->profile->getMimeType(),
                'data' => $fileData,
                'timestamp' => now()->timestamp
            ];

            // Store in localStorage via JavaScript
            $this->dispatch('store-file', fileInfo: $fileInfo);
        }
    }

    public function restoreFileFromLocalStorage()
    {
        // This will be called from JavaScript to restore file
        $this->dispatch('restore-file');
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|same:confirm_password',
            'profile' => 'nullable|image|max:2048', // up to 2MB
        ]);

        $user->FirstName = $this->first_name;
        $user->MiddleName = $this->middle_name;
        $user->LastName = $this->last_name;
        $user->extension_name = $this->extension_name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        // Handle profile photo upload
        if ($this->profile) {
            // Store image in storage/app/public/profiles and save relative path
            $path = $this->profile->store('profiles', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        // Reset only the file input after saving
        $this->reset('profile');

        session()->flash('success', 'Profile updated successfully!');
    }

    public function removeProfilePicture()
    {
        $user = Auth::user();
        if ($user->profile_picture) {
            // Delete the file from storage
            Storage::disk('public')->delete($user->profile_picture);
            $user->profile_picture = null;
            $user->save();

            session()->flash('success', 'Profile picture removed successfully!');
        }
    }

    public function render()
    {
        return view('livewire.profile.modal');
    }
}
