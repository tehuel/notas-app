<?php

namespace Database\Factories;

use App\Models\ClassDay;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_day_id' => ClassDay::factory(),
            'student_id' => Student::factory(),
            'present' => $this->faker->boolean(80),
            'status' => $this->faker->randomElement(['', 'late', 'excused']),
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}
