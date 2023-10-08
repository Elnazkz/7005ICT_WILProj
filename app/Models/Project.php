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
        'assigned_students',
        'year',
        'trimester',
        'user_id',
        'contact_name',
        'contact_email'
    ];

//    protected $cast = [
//        'id' => 'integer',
//    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function project_users() {
        return $this->hasMany(ProjectUser::class, 'project_id', 'id');
    }

    public function project_files() {
        return $this->hasMany(ProjectFile::class, 'project_id', 'id');
    }

    public function project_images() {
        return $this->hasMany(ProjectImage::class, 'project_id', 'id');
    }
}
