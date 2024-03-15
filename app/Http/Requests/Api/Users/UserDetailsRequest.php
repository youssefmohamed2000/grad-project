<?php

namespace App\Http\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailsRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'drugs' => ['nullable', 'string'],
            'blood_transfusion' => ['required', 'in:0,1'],
            'allergy' => ['nullable', 'string'],
            'children_no' => ['required', 'integer'],
            'last_child_age' => ['nullable', 'integer'],
            'booked_before' => ['required', 'in:0,1'],
            'booked_reason' => ['nullable', 'string'],
            'booked_duration' => ['nullable', 'string', 'max:100'],
            'blood_type' => ['required', 'in:a+,a-,b+,b-,o+,o-,ab+,ab-'],
            'chronic_diseases' => ['nullable', 'array'],
            'chronic_diseases.*' => ['exists:chronic_diseases,id'],
        ];
    }
}
