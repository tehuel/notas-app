<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subject = fake()->randomElement([
            'Emprendimientos e Innovación Productiva',
            'Evaluación de Proyectos',
            'Modelos y Sistemas II',
            'Organización y Métodos',
            'Desarrollo de Software para Plataformas Móviles',
            'Diseño e Implementación de Sitios Web',
            'Prácticas Profesionalizantes',
        ]);
        $division = fake()->randomElement(['1ro', '2do', '3ro', '4to', '5to', '6to', '7mo']).' '.fake()->randomElement(['1ra', '2da', '3ra', '4ta']);
        $orientation = fake()->randomElement([
            'Programación',
            'Informática',
            'Redes',
            'Electrónica',
        ]);
        $year = fake()->numberBetween(now()->subYears(2)->year, now()->addYears(2)->year);

        return [
            'subject' => $subject,
            'division' => $division,
            'orientation' => $orientation,
            'year' => $year,
            'description' => fake()->optional()->paragraph(),
        ];
    }
}
