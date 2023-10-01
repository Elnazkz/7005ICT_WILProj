<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;

    protected $table = 'project_images';

    protected $fillable = [
        'file_path',
        'project_id',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
