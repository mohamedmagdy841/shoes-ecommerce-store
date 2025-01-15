<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\api\SendOtpVerifyUserEmail;
use App\Traits\HttpResponse;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    use HttpResponse;

    protected $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }

    public function verifyEmail(Request $request)
    {
        $request->validate(['token'=>['required' , 'max:8']]);
        $user = $request->user();
        if($user->email_verified_at != null){
            return $this->sendResponse([], 'Email is already verified', 200);
        }

        $otp2 = $this->otp->validate($user->email , $request->token);

        if($otp2->status == false){
            return $this->sendResponse([], 'Code is invalid', 400);
        }

        if ($user->update(['email_verified_at' => now()])) {
            return $this->sendResponse([], 'Email Verified successfully', 200);
        }

        return $this->sendResponse([], 'Failed to update email verification', 500);
    }

    public function sendOtpAgain()
    {
        $user = request()->user();
        $user->notify(new SendOtpVerifyUserEmail());

        return $this->sendResponse([], 'Otp Sent Successfully!', 200);
    }
}
