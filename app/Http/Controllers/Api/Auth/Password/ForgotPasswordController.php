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
        try {
            $request->validate([
                'email' => 'required|string|email|exists:users,email',
            ]);

            $user = User::whereEmail($request->email)->firstOrFail();
            $user->notify(new SendOtpResetPassword());

            return $this->sendResponse([], 'OTP sent. Check your email.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->sendResponse([], 'User not found', 404);
        } catch (\Exception $e) {
            return $this->sendResponse([], 'Something went wrong. Please try again.', 500);
        }
    }
}
