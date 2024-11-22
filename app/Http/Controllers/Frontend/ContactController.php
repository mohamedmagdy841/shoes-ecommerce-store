<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();
        if(!$data)
        {
            flash()->error('Something went wrong!');
            return redirect()->back();
        }
        Contact::create($data);
        flash()->success('Thank you for contacting us!');
        return redirect()->back();
    }
}
