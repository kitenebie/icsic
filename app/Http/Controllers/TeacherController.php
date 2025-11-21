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
                Group::firstOrCreate(
                    ['name' => $groupName],
                    ['author_id' => 1]
                );
                Group::firstOrCreate(
                    ['name' => $ParentgroupName],
                    ['author_id' => 1]
                );
            }
        }

        return response()->json([
            'teachers' => $teachers]);
    }
}
