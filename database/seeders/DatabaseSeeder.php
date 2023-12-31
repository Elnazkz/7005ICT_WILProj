<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesUserRolesTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(ProjectFilesSeeder::class);
        $this->call(ProjectImagesSeeder::class);
        $this->call(ProjectUsersTableSeeder::class);
    }
}
