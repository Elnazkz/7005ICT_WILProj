<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        foreach ($projects as $project) {
            $noStudents = 0;
            $noRoles = fake()->numberBetween(1, 4);
            for ($i = 0; $i < $noRoles; $i++) {
                do {
                    $project_role = ProjectRole::factory()->make();
                    $role_id = $project_role->role_id;
                    $project_id = $project->id;
                    $count = ProjectRole::where('project_id', '=', $project_id)->where('role_id', '=', $role_id)->count();
                } while ($count > 0);
                $noStudents += $project_role->nop;
                $project_role->project_id = $project_id;
                $project_role->save();
            }
            $project->needed_students = $noStudents;
            $project->save();
        }

        $this->command->info("Project Roles created successfully.");
    }
}
