<?php

namespace App\Http\Requests\Api\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class AiRequest extends FormRequest
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
            'file' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    $model = request()->input('model');
                    if (!in_array($model, ['brain', 'kidney']) && empty($value)) {
                        $fail('The ' . $attribute . ' field is required unless the model is brain or kidney.');
                    }
                },
                'image',
                'mimes:jpeg,png,jpg,gif,svg'
            ],
            'model' => ['required', 'string'],
            
            'Bp' => ['required_if:model,kidney', 'integer'],
            'Sg' => ['required_if:model,kidney', 'integer'],
            'Al' => ['required_if:model,kidney', 'integer'],
            'Su' => ['required_if:model,kidney', 'integer'],
            'Rbc' => ['required_if:model,kidney', 'integer'],
            'Bu' => ['required_if:model,kidney', 'integer'],
            'Sc' => ['required_if:model,kidney', 'integer'],
            'Sod' => ['required_if:model,kidney', 'integer'],
            'Pot' => ['required_if:model,kidney', 'integer'],
            'Hemo' => ['required_if:model,kidney', 'integer'],
            'Wbcc' => ['required_if:model,kidney', 'integer'],
            'Rbcc' => ['required_if:model,kidney', 'integer'],
            'Htn' => ['required_if:model,kidney', 'integer'],

            'pregnancies' => ['required_if:model,diabetes', 'integer'],
            'glucose' => ['required_if:model,diabetes', 'integer'],
            'blood_pressure' => ['required_if:model,diabetes', 'integer'],
            'skin_thickness' => ['required_if:model,diabetes', 'integer'],
            'insulin' => ['required_if:model,diabetes', 'integer'],
            'bmi' => ['required_if:model,diabetes', 'integer'],
            'diabetes_pedigree_function' => ['required_if:model,diabetes', 'integer'],
            'age' => ['required_if:model,diabetes', 'integer'],

            'texture_mean' => ['required_if:model,breast', 'integer'],
            'smoothness_mean' => ['required_if:model,breast', 'integer'],
            'compactness_mean' => ['required_if:model,breast', 'integer'],
            'concave_points_mean' => ['required_if:model,breast', 'integer'],
            'symmetry_mean' => ['required_if:model,breast', 'integer'],
            'fractal_dimension_mean' => ['required_if:model,breast', 'integer'],
            'texture_se' => ['required_if:model,breast', 'integer'],
            'area_se' => ['required_if:model,breast', 'integer'],
            'smoothness_se' => ['required_if:model,breast', 'integer'],
            'compactness_se' => ['required_if:model,breast', 'integer'],
            'concavity_se' => ['required_if:model,breast', 'integer'],
            'concave_points_se' => ['required_if:model,breast', 'integer'],
            'symmetry_se' => ['required_if:model,breast', 'integer'],
            'fractal_dimension_se' => ['required_if:model,breast', 'integer'],
            'texture_worst' => ['required_if:model,breast', 'integer'],
            'area_worst' => ['required_if:model,breast', 'integer'],
            'smoothness_worst' => ['required_if:model,breast', 'integer'],
            'compactness_worst' => ['required_if:model,breast', 'integer'],
            'concavity_worst' => ['required_if:model,breast', 'integer'],
            'concave_points_worst' => ['required_if:model,breast', 'integer'],
            'symmetry_worst' => ['required_if:model,breast', 'integer'],
            'fractal_dimension_worst' => ['required_if:model,breast', 'integer'],
        ];
    }
}
