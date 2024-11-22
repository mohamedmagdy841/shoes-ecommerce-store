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
        $data = $request->validate([
            'email' => 'required|email|unique:subscribers',
        ]);

        if (!$data)
        {
            flash()->error('Something went wrong!');
        }

        Subscriber::create($data);
        Mail::to($request->email)->send(new NewSubscriberMail());
        flash()->success('Thanks for subscribing!');

        return redirect()->back();
    }
}
