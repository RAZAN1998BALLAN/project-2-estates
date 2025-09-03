<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEstateRequest extends FormRequest
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
            'title' => 'required|string|min:1|max:255',
            'image' => 'required|image|max:4096',
            'description' => 'required|string|min:1|max:510',
            'price' => 'required|int|min:1',
            'address' => 'required|string|min:1|max:255',
            'location' => 'required|array',
            'location.lat' => 'required|numeric|min:-90.0|max:90.0',
            'location.lon' => 'required|numeric|min:-180.0|max:180.0',
            'area' => 'required|numeric|min:0',
            'listing_type' => 'required|in:sale,rent',
            'estate_type' => 'required|in:villa,land,flat,house,other',
            'other_data' => 'required|array',
        ];
    }
}
