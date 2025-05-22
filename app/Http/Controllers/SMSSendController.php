<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\VonageSmsService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SMSSendController extends Controller
{
    public function sendSms(VonageSmsService $vonageSmsService, Request $request)
    {

        $otp = random_int(100000, 999999);

        $pi_contact_info = User::find($request->id);

        $pi_contact_info->otp = $otp;

        $pi_contact_info->save();

        $to = $pi_contact_info->mobile;
        $message = "Hi {$pi_contact_info->firstname}, Your One-Time Password (OTP) is: {$otp} Please enter this code in the app to verify your identity. Thank you,\n";

        try {
            // $vonageSmsService->sendSms($to, $message);
            return response()->json(['status' => 'success', 'otp' => $otp, 'message' => 'SMS sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to send SMS: ' . $e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $user = User::find($request->id);

        if ($user->otp != $request->otp) {
            throw ValidationException::withMessages([
                'message' => ['Invalid OTP, please try again.'],
            ]);
        }

        $user->otp_verified_at = now();

        $user->save();

        return response()->json([
            'status' => true,
            'otp_verified_at' => true,
            'otp' => $user->otp,
            'message' => 'OTP verified successfully.',
        ]);

        // if ($user->otp == $request->otp) {
        //     return response()->json(['status' => true, 'message' => 'OTP verified successfully.']);
        // } else {
        //     return response()->json(['status' => false, 'message' => 'Invalid OTP.'], 401);
        // }
    }
}
