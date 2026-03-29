<?php

namespace App\Http\Requests\seller\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->store;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',                          // ✅ removed lt:price
            'discount_price' => 'nullable|numeric|min:0|lt:price',        // ✅ lt:price belongs here
            'category_id' => 'required|exists:categories,id',             // ✅ fixed name + separator
            'is_negotiable' => 'nullable|boolean',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagesinternal.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deleted_images' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'name.max' => 'Product name must not exceed 255 characters.',

            'description.required' => 'Description is required.',

            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price must be at least 0.',

            'discount_price.numeric' => 'Discount must be a number.',
            'discount_price.min' => 'Discount must be at least 0.',
            'discount_price.lt' => 'Discount must be less than the price.',

            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category is invalid.',

            'primary_image.image' => 'Primary image must be an image.',
            'primary_image.mimes' => 'Primary image must be jpeg, png, jpg, or gif.',
            'primary_image.max' => 'Primary image must not exceed 2MB.',

            'imagesinternal.*.image' => 'Each gallery file must be an image.',
            'imagesinternal.*.mimes' => 'Gallery images must be jpeg, png, jpg, or gif.',
            'imagesinternal.*.max' => 'Each image must not exceed 2MB.',
        ];
    }
}
