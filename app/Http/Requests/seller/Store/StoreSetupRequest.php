<?php

namespace App\Http\Requests\Seller\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetupRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',

            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',

            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=200,min_height=200,max_width=1000,max_height=1000',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=1200,min_height=300,max_width=3000,max_height=1000',
        ];
    }
}
