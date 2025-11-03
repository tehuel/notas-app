<?php

namespace Database\Factories;

use App\Enums\GradeTypeEnum;
use App\Models\Assessment;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gradeType = fake()->randomElement(GradeTypeEnum::cases());
        $gradeValue = $this->getGradeValueForType($gradeType);

        return [
            'type' => $gradeType,
            'value' => $gradeValue,
            'assessment_id' => Assessment::factory(),
            // placeholder for gradable_id and gradable_type
            'gradable_id' => null,
            'gradable_type' => null,
            'comment' => $this->faker->sentence,
        ];
    }

    public function forStudent(?Student $student = null): static
    {
        return $this->state(function (array $attributes) use ($student) {
            return [
                'gradable_id' => $student->id ?? Student::factory(),
                'gradable_type' => Student::class,
            ];
        });
    }

    public function forStudentGroup(?StudentGroup $studentGroup = null): static
    {
        return $this->state(function (array $attributes) use ($studentGroup) {
            return [
                'gradable_id' => $studentGroup->id ?? StudentGroup::factory(),
                'gradable_type' => StudentGroup::class,
            ];
        });
    }

    public function ofType(GradeTypeEnum $type): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => $type,
                'value' => $this->getGradeValueForType($type),
            ];
        });
    }

    private function getGradeValueForType(GradeTypeEnum $type): ?string
    {
        return match ($type) {
            GradeTypeEnum::Numeric => (string) $this->faker->numberBetween(1, 10),
            GradeTypeEnum::PassFail => $this->faker->boolean() ? 'pass' : 'fail',
            GradeTypeEnum::Semaphore => $this->faker->randomElement(['unsatisfactory', 'warning', 'satisfactory']),
        };
    }

    public function configure()
    {
        return $this
            ->afterMaking(function (Grade $grade) {
                // if an Assessment is set, ensure grade type matches
                if ($grade->assessment && $grade->assessment->grade_type) {
                    $grade->type = $grade->assessment->grade_type;
                    $grade->value = $this->getGradeValueForType($grade->type);
                }
            })->afterCreating(function (Grade $grade) {
                if ($grade->assessment && $grade->assessment->grade_type) {
                    $grade->update([
                        'type' => $grade->assessment->grade_type,
                        'value' => $this->getGradeValueForType($grade->assessment->grade_type),
                    ]);
                }
            });
    }
}
