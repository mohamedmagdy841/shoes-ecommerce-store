<?php

namespace App\Http\Controllers\UserAuth;

use App\Events\NewUserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\NewUserRegisterd;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config("services.recaptcha.secret_key"),
            'response' => $request->input('g-recaptcha-response'),
        ]);

        $data = $response->json();

        if ($data['success'] == false) {
            throw ValidationException::withMessages(['g-recaptcha-response' => 'Invalid ReCAPTCHA']);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));

        $admins = Admin::get();
        Notification::send($admins, new NewUserRegisterd($user));

        NewUserRegisteredEvent::dispatch($user);

        Auth::login($user);

        return to_route('frontend.index');
    }
}
