<?php

namespace App\Livewire\Request;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Form extends Component
{
    public function selectCategory($id)
    {
        Log::info('form ID: ' . $id);
        return $this->dispatch('form', id: $id);
    }
    public function render()
    {
        return view('livewire.request.form');
    }
}
