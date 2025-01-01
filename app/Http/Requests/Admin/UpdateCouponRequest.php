<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'code' => 'nullable|string|min:5|max:10|unique:coupons,code,' . $this->coupon->id,
            'type' => 'nullable|in:percentage,fixed',
            'value' => 'nullable|integer|min:1|max:100',
            'limit' => 'nullable|integer|min:1|max:100',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }
}
