<?php

namespace App\Http\Requests\Api\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class OperationUpdateRequest extends FormRequest
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
            'user_id' => 'required|numeric|exists:users,id',
            'type' => 'required|string',
            'date' => 'nullable|date',
            'effect' => 'nullable|string',
            'doctor_name' => 'nullable|string',
        ];
    }
}
