<?php

namespace Database\Factories;

use App\Models\ProjectRole;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectRole>
 */
class ProjectRoleFactory extends Factory
{
    protected $model = ProjectRole::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => Role::all()->random()->id,
            'nop' => fake()->numberBetween(1, 2),
        ];
    }
}
