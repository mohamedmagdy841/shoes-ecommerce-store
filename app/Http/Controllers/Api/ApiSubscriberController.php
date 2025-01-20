<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewSubscriberMail;
use App\Models\Subscriber;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApiSubscriberController extends Controller
{
    use HttpResponse;

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:subscribers',
        ]);

        if(!$data)
        {
            return $this->sendResponse([], 'Something went wrong', 422);
        }

        Subscriber::create($data);
        Mail::to($request->email)->send(new NewSubscriberMail());
        return $this->sendResponse([], 'Thanks for subscribing.', 200);
    }
}
