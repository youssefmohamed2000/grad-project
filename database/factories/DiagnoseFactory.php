<?php

namespace Database\Factories;

use App\Models\Complain;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnose>
 */
class DiagnoseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'complain_id' => Complain::all()->random()->id,
            'doctor_id' => Doctor::all()->random()->id,
            'diagnose' => $this->faker->text,
        ];
    }
}
