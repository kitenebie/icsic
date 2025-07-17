<?php

namespace App\Livewire\Guardian;

use Livewire\Component;
use App\Models\guardian as Guardian;
use Illuminate\Support\Facades\Auth;

class SelectStudents extends Component
{
    public $showConfirmModal = false;
    public $showVerificationFormModal = false;
    public function verify()
    {
        $this->showConfirmModal = false;
        return $this->showVerificationFormModal = true;

    }
    public function limited()
    {
        $this->showConfirmModal = false;
        return $this->showVerificationFormModal = false;
    }
    public function mount()
    {
        if(!Auth::user()->role == "admin" && Guardian::where('students_lrn', null)->where('email', Auth::user()->email)->get()->count() == 0)
        {
            return $this->showConfirmModal = true;
        }
    }
    public function submit()
    {
        dd("working...");
    }
    public function render()
    {
        return view('livewire.guardian.select-students');
    }
}
