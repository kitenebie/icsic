<?php

namespace App\Livewire\Request;

use App\Models\DocumentRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StatusRequest extends Component
{
    public function render()
    {
        return view('livewire.request.status-request',[
            'pending' => DocumentRequest::where('user_id', Auth::user()->id)->where('status', 'pending')->get(),
            'approved' => DocumentRequest::where('user_id', Auth::user()->id)->where('status', 'approved')->get(),
            'rejected' => DocumentRequest::where('user_id', Auth::user()->id)->where('status', 'rejected')->get(),
        ]);
    }
}
