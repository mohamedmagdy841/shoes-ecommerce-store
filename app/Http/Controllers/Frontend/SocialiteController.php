<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function login($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function redirect($provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider)->user();
            $userFromDB = User::whereEmail($socialiteUser->getEmail())->first();
            if($userFromDB){
                Auth::login($userFromDB);
                return to_route('frontend.index');
            }

            $user = User::create([
                'provider' => $provider,
                'provider_id' => $socialiteUser->getId(),
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'password' => Hash::make('123456789'),
            ]);

            Auth::login($user);

            return redirect()->route('frontend.index');
        }catch (\Exception $e){
            return to_route('login');
        }
    }
}
