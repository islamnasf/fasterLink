<?php

namespace App\Http\Services;

use App\Mail\OtpMail;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OtpService
{

    public function sendOtpEmail($user)
    {
        $otp = $this->generateOtp($user, 'email');
        Mail::to($user->email)->send(new OtpMail($otp));
        return $otp;
    }

    public function sendOtpPhone($user)
    {
        $otp = $this->generateOtp($user, 'phone');
        ///TODO send sms
        return $otp;
    }

    public function verify($otp)
    {
        Otp::where('expires_at', '<', Carbon::now())->delete();
        $otpRecord = Otp::firstWhere('otp', $otp);
        if ($otpRecord) {
            $user = $otpRecord->user;
            $user->update(["{$otpRecord->type}_verified_at" => Carbon::now()]);
            return $user;
        }
        return null;
    }

    public function clear($user_id,$type)
    {
        Otp::where('user_id', $user_id)->where('type', $type)->delete();
    }

    private function generateOtp($user_id, $type)
    {
        do {
            $otp = rand(1000, 9999);
            $existingOtp = Otp::where('otp', $otp)->first();
        } while ($existingOtp);

        Otp::create([
            'user_id' => $user_id,
            'otp' => $otp,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        return $otp;
    }
}
