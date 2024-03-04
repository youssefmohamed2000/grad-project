<?php

namespace App\Http\Requests\Api\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:191',
            'section_id' => 'sometimes|required|exists:sections,id',
            'email' => 'sometimes|required|string|email|max:255|unique:doctors,email',
            'password' => 'sometimes|required|confirmed|string|max:255',
            'phone' => 'sometimes|required|string|max:100',
        ];
    }
}
