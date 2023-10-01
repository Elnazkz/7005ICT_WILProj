<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model
{
    use HasFactory;

    protected $table = 'project_roles';

    protected $fillable = [
        'project_id',
        'role_id',
        'nop',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

//    public function role_projects() {
//        return $this->belongsToMany(Project::class, ProjectRole::class, 'role_id', 'project_id');
//    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
