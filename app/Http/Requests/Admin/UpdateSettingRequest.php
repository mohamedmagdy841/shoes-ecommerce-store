<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'site_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'about_us' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'street' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
            'facebook' => 'nullable',
            'x' => 'nullable',
            'instagram' => 'nullable',
            'youtube' => 'nullable',
        ];
    }
}
