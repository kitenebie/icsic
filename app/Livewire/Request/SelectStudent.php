<?php

namespace App\Livewire\Request;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class SelectStudent extends Component
{
    public $childrens = [], $formID;

    public function boot()
    {
        $this->childrens =  DB::table('students')
            ->where('students.guardian_contact_number', Auth::user()->contact)
            ->leftJoin('users', 'students.lrn', '=', 'users.lrn')
            ->select([
                'students.id',
                'users.FirstName as firstname',
                'users.LastName as lastname',
                'users.MiddleName as middlename',
                'users.extension_name',
                'students.section',
                'students.grade',
                'students.profile',
            ])
            ->get();
    }
    public function render()
    {
        return view('livewire.request.select-student', [
            'childrens' => $this->childrens,

        ]);
    }
}
