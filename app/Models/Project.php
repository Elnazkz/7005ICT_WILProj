<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'title',
        'description',
        'needed_students',
        'year',
        'trimester',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function project_users() {
        return $this->hasMany(ProjectUser::class);
    }

    public function project_files() {
        return $this->hasMany(ProjectFile::class);
    }

    public function project_images() {
        return $this->hasMany(ProjectImage::class);
    }

    public function project_roles() {
        return $this->hasMany(ProjectRole::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
