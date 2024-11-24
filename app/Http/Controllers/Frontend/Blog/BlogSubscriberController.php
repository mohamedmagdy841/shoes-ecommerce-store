<?php

namespace App\Http\Controllers\Frontend\Blog;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewSubscriberMail;
use App\Models\BlogSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BlogSubscriberController extends Controller
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

        BlogSubscriber::create($data);
        Mail::to($request->email)->send(new NewSubscriberMail());
        flash()->success('Thanks for subscribing!');

        return redirect()->back();
    }
}
