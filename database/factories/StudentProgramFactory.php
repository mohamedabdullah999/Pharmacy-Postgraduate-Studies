<?php

namespace Database\Factories;

use App\Models\StudentProgram;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory<StudentProgram>
 */
class StudentProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::now()->subDays(rand(10, 400));
        
        return [
            'program_type' => $this->faker->randomElement(['pre_master', 'master', 'doctorate']),
            'registration_start_date' => $startDate->format('Y-m-d'),
            'registration_duration_days' => 365,
            'extension_days' => $this->faker->randomElement([0, 0, 30, 90]),
            'academic_status' => 'active',
            'thesis_title_ar' => 'دراسة تحليلية في ' . $this->faker->realText(20),
        ];
    }
}
