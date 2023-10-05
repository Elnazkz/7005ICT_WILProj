<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => config('_global.teacher'),
            'email' => '',
            'password' => Hash::make('password'),
            'approved' => true,
            'user_type' => config('_global.teacher'),
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
        User::factory()->count(30)->create();
    }
}
