<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("project_images")->insert([
            'file_path' => 'images/sample.jpg',
            'name' => 'sample',
            'project_id' => Project::all()->random()->id
        ]);
    }
}
