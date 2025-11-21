<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->select('id', 'grade', 'section')
            ->get();

        foreach ($teachers as $teacher) {

            if ($teacher->grade || $teacher->section) {

                $groupName = $teacher->grade . ($teacher->section ? '- Section ' . $teacher->section : "");
                $parentGroupName = 'Parents - ' . $teacher->grade . ($teacher->section ? '- Section ' . $teacher->section : "");

                $group = Group::firstOrCreate(
                    ['name' => $groupName],
                    ['author_id' => 1]
                );

                $group2 = Group::firstOrCreate(
                    ['name' => $parentGroupName],
                    ['author_id' => 1]
                );

                // Teacher groups
                $teacher->update([
                    'user_group' => [$group->id, $group2->id]
                ]);
            }
        }

        // Update student groups now
        $students = $this->students();

        return response()->json([
            'teachers' => $teachers,
            'students' => $students
        ]);
    }

    public function students()
    {
        $students = User::where('role', 'student')->get();

        foreach ($students as $student) {

            if ($student->student->grade || $student->student->section) {

                $groupName = $student->student->grade . ($student->student->section ? '- Section ' . $student->student->section : "");

                $group = Group::firstOrCreate(
                    ['name' => $groupName],
                    ['author_id' => 1]
                );

                $student->update([
                    'user_group' => [$group->id]
                ]);
            }
        }
        return User::where('role', 'student')->get(['grade', 'section','user_group']);
    }
}
