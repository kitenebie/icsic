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

    $all_user_group = [];
    $parent_user_group2 = [];

    foreach ($teachers as $teacher) {

        $teacherGroups = [];

        if ($teacher->grade && $teacher->section) {

            // Build names
            $groupName = $teacher->grade . '- Section ' . $teacher->section;
            $parentGroupName = 'Parents - ' . $teacher->grade . '- Section ' . $teacher->section;

            // Create groups
            $group = Group::firstOrCreate(
                ['name' => $groupName],
                ['author_id' => 1]
            );

            $group2 = Group::firstOrCreate(
                ['name' => $parentGroupName],
                ['author_id' => 1]
            );

            // Save IDs
            $all_user_group[] = $group->id;
            $parent_user_group2[] = $group2->id;

            // Teacher groups (both)
            $teacherGroups = [$group->id, $group2->id];

            User::where('id', $teacher->id)->update([
                'user_group' => $teacherGroups
            ]);

            // ---------------------------------------------------------
            // ⭐ STUDENTS ONLY GET THE MAIN CLASS GROUP ($group->id) ⭐
            // ---------------------------------------------------------
            $students = User::where('role', 'student')
                ->where('grade', $teacher->grade)
                ->where('section', $teacher->section)
                ->select('id', 'grade', 'section')
                ->get();

            foreach ($students as $student) {
                User::where('id', $student->id)->update([
                    'user_group' => [$group->id]   // Only the main class group
                ]);

                $student->groups = [$group->id];
            }
        }

        $teacher->groups = $teacherGroups;
    }

    return response()->json([
        'teachers' => $teachers,
        'all_user_group' => $all_user_group,
        'parent_user_group2' => $parent_user_group2,
    ]);
}

}
