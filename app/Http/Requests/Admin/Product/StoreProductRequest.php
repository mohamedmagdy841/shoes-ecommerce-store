<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'required',
            'status' => 'required',
            'description' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png',
            'qty' => 'required',
            'color' => 'required',
            'width' => 'required',
            'height' => 'required',
            'depth' => 'required',
            'weight' => 'required',
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
