<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inps = User::select()->where('user_type', config('_global.inp'));
        $noInps = max(intdiv($inps->count(), 2), 0);
        if ($noInps > 0) {
            $users = $inps->inRandomOrder()->limit($noInps)->get();

            $users->each(function ($user) {
                $noProjects = fake()->randomDigitNot(0);
                Project::factory()->for($user)->count($noProjects)->create();
                if ($noProjects > 0) {
                    $user->approved = true;
                    $user->save();
                }
            });
            $this->command->info("Projects created successfully " . $noInps);
        } else {
            $this->command->info('No Inps defined !');
        }
    }
}
