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
        // Delete users with emails (they will be recreated as needed)
        // Skip the protected email
        $excludeEmail = 'irosincentralschool01@gmail.com';
        User::where('email', '!=', '')
             ->where('email', '!=', $excludeEmail)
             ->delete();

        // Clear email field from students table - set to empty string instead of null
        student::where('email', '!=', '')->update(['email' => '']);

        // Clear email field from emails table (if it has an email column) - set to empty string instead of null
        if (Email::where('email', '!=', '')->exists()) {
            Email::where('email', '!=', '')->update(['email' => '']);
        }
    }

    private function deleteOrphanedUsers()
    {
        // Get all emails from students table (non-empty strings)
        $studentEmails = student::where('email', '!=', '')
                               ->pluck('email')
                               ->filter()
                               ->toArray();

        // Delete users where email is not empty and email doesn't exist in students
        // Exclude the specific email address
        $excludeEmail = 'irosincentralschool01@gmail.com';

        if (!empty($studentEmails)) {
            User::where('email', '!=', '')
                ->whereNotIn('email', $studentEmails)
                ->where('email', '!=', $excludeEmail)
                ->delete();
        } else {
            // If no student emails exist, delete all users with emails except the excluded one
            User::where('email', '!=', '')
                ->where('email', '!=', $excludeEmail)
                ->delete();
        }
    }

    private function deleteOrphanedEmailRecords()
    {
        // Get all emails from Users table (non-empty strings)
        $userEmails = User::where('email', '!=', '')
                         ->pluck('email')
                         ->filter()
                         ->toArray();

        // Delete email records where email is not empty and email doesn't exist in Users
        if (!empty($userEmails)) {
            Email::where('email', '!=', '')
                 ->whereNotIn('email', $userEmails)
                 ->delete();
        } else {
            // If no user emails exist, delete all email records with emails
            Email::where('email', '!=', '')->delete();
        }
    }
}