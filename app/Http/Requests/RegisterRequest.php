<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|min:1|max:255',
            'phone' => 'required|string|min:8|max:12',
            'password' => 'required|string|min:6|max:255',
            'location_text' => 'string|min:2|max:255',
            'location' => 'array',
            'location.lat' => 'required_with:location|numeric|min:-90.0|max:90.0',
            'location.lon' => 'required_with:location|numeric|min:-180.0|max:180.0',
            'photo' => 'image|max:4096',
            'fcm' => 'string',
        ];
    }
}
