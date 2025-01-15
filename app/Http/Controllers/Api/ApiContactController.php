<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\SettingResource;
use App\Models\Contact;
use App\Models\Setting;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class ApiContactController extends Controller
{
    use HttpResponse;

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();
        Contact::create($data);
        return $this->sendResponse(null, 'Thank you for contacting us!', 201);
    }
}
