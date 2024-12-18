<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'nullable',
            'price' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'brand' => 'nullable',
            'status' => 'nullable',
            'description' => 'nullable',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,png',
            'qty' => 'nullable',
            'color' => 'nullable',
            'width' => 'nullable',
            'height' => 'nullable',
            'depth' => 'nullable',
            'weight' => 'nullable',
        ];
    }

    // to change the name so that it doesn't appear on the page as category_id
    public function attributes(): array
    {
        return [
            'category_id' => 'category'
        ];
    }
}
