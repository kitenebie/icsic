<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use App\Models\NotListedStudent;
use App\Models\student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class selectStudentController extends Controller
{
    public function selectStudentController(Request $request, student $student, NotListedStudent $NotListedStudent, User $user)
    {
        // Explode the comma-separated string into an array of IDs
        $rstudentIds = explode(",", $request->selected_ids);

        // Track if any data was submitted
        $hasValidRequest = false;

        // Handle listed students
        if (!empty($rstudentIds) && !empty($rstudentIds[0])) {
            $student::whereIn("id", $rstudentIds)
                ->update(["remarks" => "Invalid Guardian Details"]);
            $hasValidRequest = true;
        }

        // Handle not-listed students
        if (!empty($request->student_name)) {
            foreach ($request->student_name as $name) {
                if (!empty(trim($name))) {
                    $NotListedStudent::create([
                        'studentName' => $name,
                        'parentId' => Auth::user()->id,
                        'ParentName' => Auth::user()->LastName . ', ' . Auth::user()->FirstName . ' ' . Auth::user()->MiddleName,
                        'status' => 'Requested'
                    ]);
                    $hasValidRequest = true;
                }
            }
        }

        // Only update user role if at least one valid request was made
        if ($hasValidRequest) {
            $user::where('id', Auth::user()->id)->update(['role' => 'parent']);

            $parent_user_group = [];
            $children = $student::where('guardian_contact_number', Auth::user()->contact)->get(['lrn']);
            foreach ($children as $child) {
                $studentInfo = $student::where('lrn', $child->lrn)->first();
                if ($studentInfo) {
                    $parent_user_group[] = $studentInfo->grade . "-" . $studentInfo->section;
                }
            }

            $user::where('id', Auth::user()->id)->update(['user_group' => $parent_user_group]);

            return back()->with('success', 'Your role has been updated to parent.');
        }

        return back()->with('error', 'Please select at least one student or provide a name to proceed.');
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
}
