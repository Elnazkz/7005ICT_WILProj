<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    use HasFactory;

    protected $table = 'project_users';

    protected $fillable = [
        'user_id',
        'project_id',
        'justification_note',
    ];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
