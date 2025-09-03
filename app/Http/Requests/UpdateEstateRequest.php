<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UpdateEstateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->is_admin || Route::current()->parameter('estate')->user_id == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|min:1|max:255',
            'image' => 'image|max:4096',
            'description' => 'string|min:1|max:510',
            'price' => 'int|min:1',
            'address' => 'string|min:1|max:255',
            'location' => 'array',
            'location.lat' => 'required_with:location|numeric|min:-90.0|max:90.0',
            'location.lon' => 'required_with:location|numeric|min:-180.0|max:180.0',
            'area' => 'numeric|min:0',
            'listing_type' => 'in:sale,rent',
            'estate_type' => 'in:villa,land,flat,house,other',
            'other_data' => 'array',
        ];
    }
}
