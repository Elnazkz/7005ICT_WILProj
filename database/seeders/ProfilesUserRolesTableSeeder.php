<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilesUserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::select()->where('user_type', config('_global.student'));
        $noProfiles = max(intdiv($students->count(), 2), 0);
        if ($noProfiles > 0) {
            $users = $students->inRandomOrder()->limit($noProfiles)->get();

            $users->each(function ($user) {
                $user_id = $user->id;
                $user->approved = true;
                $user->save();

                Profile::factory()->for($user)->create();

                $noRoles = fake()->numberBetween(1, 4);
                for ($i = 0; $i < $noRoles; $i++) {
                    do {
                        $user_role = UserRole::factory()->make();
                        $role_id = $user_role->role_id;
                        $count = UserRole::where('user_id', '=', $user_id)->where('role_id', '=', $role_id)->count();
                    } while ($count > 0);
                    $user_role->user_id = $user_id;
                    $user_role->save();
                }
            });
            $this->command->info("Profiles and User role created successfully " . $noProfiles);
        } else {
            $this->command->info('No student defined !\n');
        }
    }
}
