<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(rand(5, 15), true),
            'description' => fake()->paragraph(),
            'needed_students' => fake()->numberBetween(3, 6),
            'year' => fake()->numberBetween(2020, 2030),
            'trimester' => fake()->numberBetween(1, 3),
        ];
    }
}
