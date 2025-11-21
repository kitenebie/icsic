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

            // Initialize fresh arrays for each teacher
            $teacherGroups = [];

            if ($teacher->grade && $teacher->section) {

                $groupName = $teacher->grade . '- Section ' . $teacher->section;
                $parentGroupName = 'Parents - ' . $teacher->grade . '- Section ' . $teacher->section;

                // Find or create
                $group = Group::firstOrCreate(
                    ['name' => $groupName],
                    ['author_id' => 1]
                );
                $group2 = Group::firstOrCreate(
                    ['name' => $parentGroupName],
                    ['author_id' => 1]
                );

                // Push into main arrays
                $all_user_group[] = $group->id;
                $parent_user_group2[] = $group2->id;

                // Assign groups to the user
                $teacherGroups = [$group->id, $group2->id];

                // Save to user
                User::where('id', $teacher->id)->update([
                    'user_group' => $teacherGroups
                ]);
            }

            // This will now contain actual group IDs
            $teacher->groups = $teacherGroups;
        }

        return response()->json([
            'teachers' => $teachers,
            'all_user_group' => $all_user_group,
            'parent_user_group2' => $parent_user_group2,
        ]);
    }
}
