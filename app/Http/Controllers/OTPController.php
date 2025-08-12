<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Mail\CreatePassword;
use App\Models\Email;
use App\Models\Otp;
use App\Models\User;
use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OTPController extends Controller
{
    public function sentOtp()
    {
        $userId = Auth::user()->id;
        $filter = Otp::where('user_id', $userId)->first();

        // If OTP exists, check if it's still valid (within 5 mins)
        if ($filter && $filter->created_at) {
            $expiresAt = Carbon::parse($filter->created_at)->addMinutes(5);

            if (Carbon::now()->lessThan($expiresAt)) {
                // Still valid — reuse existing OTP
                session(['otp' => $filter->code]);
                return view('otp')->with('countdown', $expiresAt->timestamp);
            } else {
                // Expired — delete old OTP
                $filter->delete();
            }
        }

        // Create a new OTP
        $otp = rand(1000, 9999);
        session(['otp' => $otp]);

        Otp::updateOrCreate(
            ['user_id' => $userId],
            ['code' => $otp]
        );
        Sms::updateOrCreate(
            ['numbers' => [Auth::user()->contact]],
            ['Content' => "Your OTP " . $otp]
        );

        // Send the email
        Mail::to(Auth::user()->email)->send(new OtpMail($otp));

        return view('otp')->with('countdown', now()->addMinutes(5)->timestamp);
    }


    public function verifyOtp($code)
    {
        try {
            Log::info('OTP verification started', ['user_id' => Auth::id()]);

            if (!Auth::check()) {
                Log::warning('OTP verify failed - user not logged in');
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Please log in.'
                ], 401);
            }

            $user = Auth::user();

            $otpRecord = Otp::where('user_id', $user->id)
                ->where('code', $code)
                ->first();

            if (!$otpRecord) {
                Log::warning('OTP verify failed - invalid or expired code', ['user_id' => $user->id, 'code' => $code]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired OTP code.'
                ], 400);
            }

            // Fix this line: you probably want to delete the OTP by otpRecord id, not user id
            Otp::where('id', $otpRecord->id)->delete();
            Log::info('OTP record deleted', ['otp_id' => $otpRecord->id, 'user_id' => $user->id]);

            $user->email_verified_at = now();
            $updated = $user->save();

            if (!$updated) {
                Log::error('Failed to update email_verified_at', ['user_id' => $user->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update verification timestamp.'
                ], 500);
            }

            Auth::user()->refresh();
            Log::info('User email verified successfully', ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Your email has been verified successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('OTP verification error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
                'error' => $e->getMessage(), // remove in production
            ], 500);
        }
    }


    public function sendEmail($email)
    {
        try {
            $token = $email; // Replace with real token logic if needed
            Mail::to($email)->send(new CreatePassword($token));

            // If no exception, email sent successfully
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send email to {$email}: " . $e->getMessage());
            return false;
        }
    }

    public function SendNewEmailsContinuesly()
    {
        try {
            $users = User::whereNull('email_verified_at')->get();

            foreach ($users as $user) {
                $emailRecord = Email::where('email', $user->email)->first();

                if (!$emailRecord) {
                    // First time sending
                    $this->sendEmail($user->email);
                    Email::create([
                        'email' => $user->email,
                        'updated_at' => now()
                    ]);
                } else {
                    // Check if last sent is more than 5 minutes ago
                    if ($emailRecord->updated_at->lt(Carbon::now()->subMinutes(5))) {
                        $this->sendEmail($user->email);
                        $emailRecord->touch(); // updates updated_at
                    }
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    public function createNewPassword($token, $email)
    {
        $isEmail = Email::where('email', $email)->first();

        if (!$isEmail) {
            return view('emailBypass');
        }
        Session::put('email_temp', $email);

        return view('VerificationPassword');
    }

    public function verifyPassword($password)
    {
        try {
            $email = Session::get('email_temp');

            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'No email found in session.'
                ], 400);
            }

            // Find the user
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'No user found with that email.'
                ], 404);
            }

            // Update password
            $user->password = Hash::make($password);
            $user->save();

            // Auto authenticate the user
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Password updated & email verified.',
                'redirect' => '/otp'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again later. ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
