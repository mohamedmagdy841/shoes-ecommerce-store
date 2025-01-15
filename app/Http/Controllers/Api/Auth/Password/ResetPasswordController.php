<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HttpResponse;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use HttpResponse;
    private $otp2;
    public function __construct()
    {
        $this->otp2 = new Otp();
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'code' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $otp = $this->otp2->validate($request->email , $request->code);

        if($otp->status == false){
            return $this->sendResponse([], 'Code is invalid', 400);
        }

        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return $this->sendResponse([], 'User not found', 404);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return $this->sendResponse([], 'Password Updated Successfully', 200);
    }
}
