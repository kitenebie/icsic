<?php

namespace App\Livewire\UserRole;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class ModalParent extends Component
{
    public $studentIds;

    public function submitSelection()
    {
        dd($this->studentIds);
        // Ensure input is parsed into array
        if (is_string($this->studentIds)) {
            $this->studentIds = array_filter(explode(',', $this->studentIds));
        }

        if (count($this->studentIds) > 0) {
            dd('message', 'Selected student IDs: ' . implode(', ', $this->studentIds));
        } else {
            dd('error', 'Please select at least one child.');
        }
    }

    public function render()
    {
        return view('livewire.user-role.modal-parent', [
            'childrens' => DB::table('students')
                ->where('students.guardian_contact_number', Auth::user()->contact)
                ->leftJoin('users', 'students.lrn', '=', 'users.lrn')
                ->select([
                    'students.id',
                    'users.FirstName as firstname',
                    'users.LastName as lastname',
                    'users.MiddleName as middlename',
                    'students.section',
                    'students.grade',
                    'users.extension_name',
                    'students.profile',
                ])
                ->get(),

        ]);
    }
}
