<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

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
        $user = auth()->user();
        $this->first_name = $user->FirstName;
        $this->middle_name = $user->MiddleName;
        $this->last_name = $user->LastName;
        $this->extension_name = $user->extension_name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        $user = auth()->user();

        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|same:confirm_password',
        ]);

        $user->FirstName = $this->first_name;
        $user->MiddleName = $this->middle_name;
        $user->LastName = $this->last_name;
        $user->extension_name = $this->extension_name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('success', 'Profile updated successfully!');
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.profile.modal');
    }
}
