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
        try {
            $data = $request->validated();
            Contact::create($data);
            flash()->success('Thank you for contacting us!');
        } catch (\Exception $e) {
            flash()->error('Something went wrong! Please try again.');
        }

        return redirect()->back();
    }

}
