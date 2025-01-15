<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\api\SendOtpResetPassword;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use HttpResponse;
    public function sendOtpEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
        ]);

        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return $this->sendResponse([], 'User not found', 404);
        }

        $user->notify(new SendOtpResetPassword());
        return $this->sendResponse([], 'Otp Sent, Check Your Email');
    }
}
