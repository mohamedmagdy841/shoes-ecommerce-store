<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\SendOtpVerifyUserEmail;
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

        $otp2 = $this->otp->validate($user->email , $request->token);
        if($otp2->status == false){
            return $this->sendResponse([], 'Code is invalid', 400);
        }

        $user->update(['email_verified_at'=>now()]);
        return $this->sendResponse([], 'Email Verified successfully', 200);
    }

    public function sendOtpAgain()
    {
        $user = request()->user();
        $user->notify(new SendOtpVerifyUserEmail());

        return $this->sendResponse([], 'Otp Sent Successfully!', 200);
    }
}
