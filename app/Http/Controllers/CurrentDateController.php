<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class CurrentDateController extends Controller
{
    /**
     * Get the current date and time
     *
     * @return JsonResponse
     */
    public function getCurrentDate(): JsonResponse
    {
        // Set timezone to Asia/Manila
        $currentDateTime = Carbon::now('Asia/Manila');
        
        // Check if current time is >= November 10, 2025
        $expiryDate = Carbon::create(2025, 11, 10, 0, 0, 0, 'Asia/Manila');
        $canAccess = env('SYS_NOT_PAID') ? true :$currentDateTime->lt($expiryDate);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Current date and time (Asia/Manila timezone)',
            'data' => [
                'current_date_time' => $currentDateTime->toISOString(),
                'formatted_date' => $currentDateTime->format('Y-m-d H:i:s'),
                'timezone' => $currentDateTime->timezoneName,
                'timestamp' => $currentDateTime->timestamp,
                'can_access' => $canAccess,
                'expiry_date' => $expiryDate->toISOString(),
                'is_expired' => env('SYS_PAID') ? false : !$canAccess
            ]
        ]);
    }
}