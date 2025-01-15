<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\NewUserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailVerifyJob;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\api\SendOtpVerifyUserEmail;
use App\Notifications\NewUserRegisterd;
use App\Traits\HttpResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    use HttpResponse;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if(RateLimiter::tooManyAttempts($request->ip(), 3)) {
            $seconds = RateLimiter::availableIn($request->ip());
            return $this->sendResponse([], 'Too many attempts, try after '. $seconds . ' seconds', 429);
        }

        RateLimiter::increment($request->ip());

        $user = User::whereEmail($request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('user_token' , ['*'] , now()->addMinutes(60))->plainTextToken;
            RateLimiter::clear($request->ip());
            return $this->sendResponse(['token' => $token], 'You have logged in successfully', 200);
        }

        return $this->sendResponse([], "The provided credentials are incorrect.", 401);
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed',
            ]);

            $user = User::create($data);
            $token = $user->createToken('user_token' , ['*'] , now()->addMinutes(60))->plainTextToken;

            event(new Registered($user));
            $admins = Admin::get();
            Notification::send($admins, new NewUserRegisterd($user));
            NewUserRegisteredEvent::dispatch($user);
            SendEmailVerifyJob::dispatch($user);

            DB::commit();
            return $this->sendResponse(['token' => $token], 'You have logged in successfully', 201);
        } catch (\Exception $e)
        {
            DB::rollBack();
            return $this->sendResponse([], $e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return $this->sendResponse([], 'logged out successfully', 200);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse([], 'Logged out from all devices successfully.', 200);
    }
}
