<?php

namespace App\Http\Requests\Api\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class ComplainStoreRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'complain' => 'required',
            'start_date' => 'required',
            'increase_with' => 'required',
            'decrease_with' => 'required',
        ];
    }
}
