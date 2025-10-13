<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\student;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CleanupController extends Controller
{
    public function restart()
    {
        try {
            // Step 1: Clear all email fields from Users, students, and emails tables
            $this->clearAllEmails();

            // Step 2: Delete users where email doesn't exist in students records
            $this->deleteOrphanedUsers();

            // Step 3: Delete emails where email doesn't exist in Users records
            $this->deleteOrphanedEmailRecords();

            return response()->json([
                'success' => true,
                'message' => 'Cleanup completed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cleanup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function clearAllEmails()
    {
        // Clear email field from Users table
        User::whereNotNull('email')->update(['email' => null]);

        // Clear email field from students table
        student::whereNotNull('email')->update(['email' => null]);

        // Clear email field from emails table (if it has an email column)
        if (Email::whereNotNull('email')->exists()) {
            Email::whereNotNull('email')->update(['email' => null]);
        }
    }

    private function deleteOrphanedUsers()
    {
        // Get all emails from students table
        $studentEmails = student::whereNotNull('email')
                               ->pluck('email')
                               ->filter()
                               ->toArray();

        // Delete users where email is not null and email doesn't exist in students
        // Exclude the specific email address
        $excludeEmail = 'irosincentralschool01@gmail.com';

        if (!empty($studentEmails)) {
            User::whereNotNull('email')
                ->whereNotIn('email', $studentEmails)
                ->where('email', '!=', $excludeEmail)
                ->delete();
        } else {
            // If no student emails exist, delete all users with emails except the excluded one
            User::whereNotNull('email')
                ->where('email', '!=', $excludeEmail)
                ->delete();
        }
    }

    private function deleteOrphanedEmailRecords()
    {
        // Get all emails from Users table
        $userEmails = User::whereNotNull('email')
                         ->pluck('email')
                         ->filter()
                         ->toArray();

        // Delete email records where email is not null and email doesn't exist in Users
        if (!empty($userEmails)) {
            Email::whereNotNull('email')
                 ->whereNotIn('email', $userEmails)
                 ->delete();
        } else {
            // If no user emails exist, delete all email records with emails
            Email::whereNotNull('email')->delete();
        }
    }
}