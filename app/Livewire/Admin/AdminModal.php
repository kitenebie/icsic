<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;

class AdminModal extends Component
{
    public $showAdminModal = false;
    public function mount()
    {
        $this->showAdminModal = Auth::user()->role == "admin" ?  true : false;
    }
    public function dashboardDirect()
    {
        return redirect("/administrator");
    }
    public function render()
    {
        return view('livewire.admin.admin-modal');
    }
}
