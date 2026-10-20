<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name('ar_SA'),
            'national_id' => $this->faker->unique()->numerify('2#############'),
            'student_code' => $this->faker->unique()->numerify('2026####'),
            'birth_date' => $this->faker->date('Y-m-d', '2000-01-01'),
            'mobile' => $this->faker->numerify('01#########'),
        ];
    }
}
