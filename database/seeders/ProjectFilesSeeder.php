<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("project_files")->insert([
            'file_path' => 'files/sample.pdf',
            'name' => 'sample',
            'project_id' => Project::all()->random()->id
        ]);
    }
}
