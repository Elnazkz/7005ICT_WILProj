<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $all_students = User::where('user_type', '=', 'Student');
        $students_cnt = $all_students->count();
        $no_students = fake()->numberBetween(intdiv($students_cnt, 2), $students_cnt);
//        $students = $all_students->inRandomOrder()->limit($no_students)->get();
        $students = $all_students->get();

        $all_projects = Project::select();
        $project_cnt = $all_projects->count();

        foreach ($students as $student) {
            if ($student->approved) {
                $no_applied = 0;
                $no_projects = fake()->numberBetween(0, 3);
                $projects = $all_projects->inRandomOrder()->limit($no_projects)->get();
                foreach ($projects as $project) {
                    $cnt = ProjectUser::where('project_id', $project->id)->where('user_id', $student->id)->count();
                    if ($cnt === 0) {
                        $project_user = new ProjectUser();
                        $project_user->user_id = $student->id;
                        $project_user->project_id = $project->id;
                        $project_user->justification_note = fake()->words(random_int(5, 15), true);
                        $project_user->assigned = false;
                        $project_user->save();

                        $no_applied++;
                        if ($no_applied >= 3)
                            break;
                    }
                }
            }
        }

        $this->command->info("Project users created successfully !");
    }
}
