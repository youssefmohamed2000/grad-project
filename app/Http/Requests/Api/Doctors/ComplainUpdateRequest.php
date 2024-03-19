<?php

namespace App\Http\Requests\Api\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class ComplainUpdateRequest extends FormRequest
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
            'user_id' => 'sometimes|required|exists:users,id',
            'complain' => 'sometimes|required',
            'start_date' => 'sometimes|required',
            'increase_with' => 'sometimes|required',
            'decrease_with' => 'sometimes|required',
        ];
    }
}
