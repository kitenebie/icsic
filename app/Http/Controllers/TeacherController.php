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
            $teacher->groups = [];
            if ($teacher->grade && $teacher->section) {
                $groupName = $teacher->grade . '- Section ' . $teacher->section;
                $ParentgroupName = 'Parents - ' . $teacher->grade . '- Section ' . $teacher->section;

                // Find or create the group
                $group = Group::firstOrCreate(
                    ['name' => $groupName],
                    ['author_id' => 1]
                );
                $group2 = Group::firstOrCreate(
                    ['name' => $ParentgroupName],
                    ['author_id' => 1]
                );

                $parent_user_group[] = $group->id;
                $parent_user_group2[] = $group2->id;
            }
            User::where('id', $teacher->id)->update(['user_group' => $parent_user_group]);
            User::where('id', $teacher->id)->update(['user_group' => $parent_user_group2]);
        }

        return response()->json([
            'teachers' => $teachers,
            'all_user_group' => $parent_user_group,
            'parent_user_group2' => $parent_user_group2,
        ]);
    }
}
