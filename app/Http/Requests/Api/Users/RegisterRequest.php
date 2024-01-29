<?php

namespace App\Http\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|confirmed|string|max:255',
            'age' => ['required', 'integer'],
            'sex' => ['required', 'between:0,1'],
            'birth_place' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'job' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'social_status' => ['required', 'in:married, single, widow, divorced'],
        ];
    }
}
