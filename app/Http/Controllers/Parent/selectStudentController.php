<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\NotListedStudent;
use App\Models\student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class selectStudentController extends Controller
{
    public function selectStudentController(Request $request, student $student, NotListedStudent $NotListedStudent, User $user, Group $group)
    {
        $parent_user_group = [];

        $children = Student::where('guardian_contact_number', Auth::user()->contact)->get(['lrn']);

        foreach ($children as $child) {
            $studentInfo = Student::where('lrn', $child->lrn)->first();

            if ($studentInfo) {
                $groupName = $studentInfo->grade . ($studentInfo->section ?? '- Section ' . $studentInfo->section);
                $ParentgroupName = 'Parents - '.$studentInfo->grade . ($studentInfo->section ?? '- Section ' . $studentInfo->section);

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
        }


        User::where('id', Auth::user()->id)->update(['role' => 'parent']);
        User::where('id', Auth::user()->id)->update(['user_group' => $parent_user_group]);
        User::where('id', Auth::user()->id)->update(['user_group' => $parent_user_group2]);

        return back()->with('success', 'Your role has been updated to parent.');
    }


    public function selectedRequestForm(Request $request, DocumentRequest $documentRequest, student $student)
    {
        // dd($request->all());
        $rstudentIds = explode(',', $request->selected_ids);
        // Fetch students by selected IDs
        $invalidRequest = [];
        $students = Student::whereIn('students.id', $rstudentIds)
            ->join('users', 'students.email', '=', 'users.email')
            ->select([
                'students.id',
                'users.LastName',
                'users.FirstName',
                'users.MiddleName',
                'users.extension_name',
            ])
            ->get();

        foreach ($students as $student) {
            $filter = documentRequest::where('student_id', $student->id)
                ->whereIn('status', ['pending', 'approved'])
                ->where('document_type', $request->formid)
                ->where('updated_at', '>=', Carbon::now()->subMonths(2))
                ->get();

            $data = [
                'user_id'        => Auth::user()->id,
                'student_id'    => $student->id,
                'student_name'   => "{$student->LastName} {$student->FirstName}, {$student->MiddleName} {$student->extension_name}",
                'document_type'  => $request->formid,
                'status'         => 'pending',
                'reason'         => $request->message ?? "Requesting for documents",
                'document_path'  => null,
                'created_by'     => Auth::user()->id,
                'updated_by'     => null,
                'deleted_by'     => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
            if ($filter->count() > 0) {
                $invalidRequest[] = $data;
            } else {
                $documentRequest::create($data);
            }
        }
        if ($invalidRequest != []) {
            return redirect()->back()->with(['invalidRequest' => $invalidRequest]);
        }
        return redirect()->back()->with(['success' => 'All request Documents are successfully submitted']);
    }

    public function graduate(Request $request, student $student)
    {
        $student = Auth::user();
        $student->update(['role' => 'graduate']);
        $student->save();



        return redirect()->back()->with('success', 'Selected students have been marked as graduated.');
    }
}
