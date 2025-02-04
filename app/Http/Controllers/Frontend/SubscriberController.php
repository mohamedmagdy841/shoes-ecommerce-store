<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewSubscriberMail;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        try {
            $subscriber = Subscriber::create($validatedData);

            try {
                Mail::to($subscriber->email)->send(new NewSubscriberMail());
            } catch (\Exception $e) {
                flash()->error('Subscription successful, but email could not be sent.');
                return redirect()->back();
            }

            flash()->success('Thanks for subscribing!');
            return redirect()->back();

        } catch (\Exception $e) {
            flash()->error('Something went wrong! Please try again later.');
            return redirect()->back();
        }
    }

}
