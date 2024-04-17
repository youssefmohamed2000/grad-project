<?php

namespace App\Http\Requests\Api\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class DiagnoseUpdateRequest extends FormRequest
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
            'complain_id' => 'required|exists:complains,id',
            'doctor_id' => 'required|exists:doctors,id',
            'diagnose' => 'required',
        ];
    }
}
