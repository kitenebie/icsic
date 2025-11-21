<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->select('id', 'grade', 'section', 'user_group', 'updated_at')
            ->get();

        foreach ($teachers as $teacher) {

            if ($teacher->grade && $teacher->section) {

                // 💯 Normalize names
                $groupName = $this->formatGroupName($teacher->grade, $teacher->section);
                $parentGroupName = 'Parents - ' . $groupName;

                // Create or fetch groups
                $group = Group::firstOrCreate(
                    ['name' => $groupName],
                    ['author_id' => 1]
                );

                $group2 = Group::firstOrCreate(
                    ['name' => $parentGroupName],
                    ['author_id' => 1]
                );

                // Assign teacher groups
                $teacher->update([
                    'user_group' => [$group->id, $group2->id]
                ]);
            }
        }

        // Assign students to groups
        $students = $this->students();

        return response()->json([
            'teachers' => $teachers,
            'students' => $students
        ]);
    }

    // 🔧 Normalizes grade + section to match EXACT format
    private function formatGroupName($grade, $section)
    {
        $grade = trim($grade);

        // Normalize students like teachers ("6" → "Grade 6")
        if (!str_contains($grade, 'Grade')) {
            $grade = 'Grade ' . $grade;
        }

        return $grade . '- Section ' . trim($section);
    }

    public function students()
    {
        $students = User::where('role', 'student')->get();

        foreach ($students as $student) {

            if ($student->grade && $student->section) {

                // Same formatting used for teachers
                $groupName = $this->formatGroupName($student->grade, $student->section);

                $group = Group::firstOrCreate(
                    ['name' => $groupName],
                    ['author_id' => 1]
                );

                // Assign student to the group
                $student->update([
                    'user_group' => [$group->id]
                ]);
            }
        }

        return User::where('role', 'student')->get(['user_group']);
    }
}
