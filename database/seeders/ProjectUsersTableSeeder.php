<?php

namespace Database\Seeders;

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
        $inps = User::select()->where('user_type', config('_global.inps'));
        $noProfiles = max(intdiv($inps->count(), 2), 0);
        if ($noProfiles > 0) {
            $users = $inps->inRandomOrder()->limit($noProfiles)->get();

            $users->each(function ($user) {
                $user_id = $user->id;

//                Profile::factory()->for($user)->create();
//                $noRoles = fake()->numberBetween(1, 3);
//                for ($i = 0; $i < $noRoles; $i++) {
//                    do {
//                        $user_role = UserRole::factory()->make();
//                        $role_id = $user_role->role_id;
//                        $count = UserRole::where('user_id', '=', $user_id)->where('role_id', '=', $role_id)->count();
//                    } while ($count > 0);
//                    $user_role->user_id = $user_id;
//                    $user_role->save();
//                }
            });
            $this->command->info("Project users created successfully !" . $noProfiles);
        } else {
            $this->command->info('No student defined !\n');
        }
    }
}
