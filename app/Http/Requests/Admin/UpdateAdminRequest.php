<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateAdminRequest extends FormRequest
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
            'name'     => 'nullable|string',
            'phone'     => 'nullable',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'street'    => 'nullable|string',
            'city'      => 'nullable|string',
            'country'   => 'nullable|string',
            'email'    => 'nullable|email|unique:admins,email,' . $this->route()->admin->id,
            'password' => 'nullable|confirmed',
            'role'     => 'nullable',
        ];
    }
}
