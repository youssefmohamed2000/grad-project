<?php

namespace App\Http\Requests\Api\Doctors;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
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
            'name' => 'required|string|max:191',
            'section_id' => 'required|exists:sections,id',
            'email' => 'required|string|email|max:255|unique:doctors,email,' . $this->doctor,
            'password' => 'confirmed|string|max:255',
            'phone' => 'required|string|max:100',
            'image' => 'nullable|image'
        ];
    }

    protected function passedValidation()
    {
        $this->replace([
            ...$this->validated(),
            'password' => Hash::make($this->input('password'))
        ]);
    }
}
