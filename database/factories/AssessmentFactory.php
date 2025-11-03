<?php

namespace Database\Factories;

use App\Enums\AssessmentTypeEnum;
use App\Enums\GradeTypeEnum;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assessment>
 */
class AssessmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'description' => fake()->optional()->paragraph(),
            'type' => fake()->randomElement(AssessmentTypeEnum::cases()),
            'grade_type' => fake()->randomElement(GradeTypeEnum::cases()),
            'course_id' => Course::factory(),
        ];
    }

    public function individual(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => AssessmentTypeEnum::Individual,
            ];
        });
    }

    public function group(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => AssessmentTypeEnum::Group,
            ];
        });
    }
}
