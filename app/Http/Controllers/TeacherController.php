<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        $alumni = User::whereNotNull('year_graduated')->get();

        foreach ($alumni as $alum) {
            $groupName = 'Alumni ' . $alum->year_graduated;
            $group = Group::firstOrCreate(
                ['name' => $groupName],
                ['author_id' => 1]
            );
            $currentGroups = $alum->user_group ?? [];
            if (!in_array($group->id, $currentGroups)) {
                $currentGroups[] = $group->id;
                $alum->update(['user_group' => $currentGroups]);
            }
        }

        return User::where('role', 'student')->get(['grade', 'section', 'user_group']);
    }
}
