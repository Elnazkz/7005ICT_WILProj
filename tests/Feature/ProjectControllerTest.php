<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * test for successful project creation
     */
    public function test_create_project_success()
    {
        $user = User::factory()->create(); // Create a user for testing
        $this->actingAs($user); // Log in as the user

        $response = $this->post('/project_creation', [
            'title' => 'Test Project in test',
            'description' => 'This is a test project',
            'needed_students' => 4,
            'year' => 2023,
            'trimester' => 2
        ]);

        $response->assertStatus(302); // Assuming you're redirecting after successful creation
        $response->assertSessionHas('success', 'Project created successfully');
        $this->assertDatabaseHas('projects', ['title' => 'Test Project in test']);
    }

    public function test_create_project_input_validation_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/project_creation', [
            'title' => '', // Invalid title
            'description' => 'Short description', // Invalid description
            'needed_students' => 2, // Invalid number of needed students
            'year' => 2023,
            'trimester' => 5 // Invalid trimester
        ]);

        $response->assertStatus(302); // Assuming you're redirecting after validation error
        $response->assertSessionHasErrors(['title', 'description', 'needed_students', 'trimester']);
        $this->assertDatabaseCount('projects', 0); // No project should be created due to validation errors
    }
}
