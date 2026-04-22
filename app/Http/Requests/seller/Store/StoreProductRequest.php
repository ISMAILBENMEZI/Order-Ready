<?php

namespace App\Http\Requests\Seller\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role->name === 'seller';
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
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagesinternal' => 'nullable|array',
            'imagesinternal.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
