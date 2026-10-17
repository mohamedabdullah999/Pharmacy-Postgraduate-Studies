<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ActivationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'national_id' => ['required', 'string'],
            'activation_code' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
