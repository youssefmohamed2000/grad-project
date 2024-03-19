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
            'user_id' => 'sometimes|required|numeric|exists:users,id',
            'type' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'effect' => 'sometimes|required|string',
            'doctor_name' => 'sometimes|required|string',
        ];
    }
}
