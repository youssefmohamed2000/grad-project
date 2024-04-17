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
            'name' => 'required|required|string|max:191',
            'section_id' => 'required|required|exists:sections,id',
            'email' => 'required|required|string|email|max:255|unique:doctors,email,' . $this->doctor,
            'password' => 'required|required|confirmed|string|max:255',
            'phone' => 'required|required|string|max:100',
        ];
    }
}
