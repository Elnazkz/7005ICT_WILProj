<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'title',
    ];

    public function user_roles() {
        return $this->hasMany(UserRole::class, 'role_id', 'id');
    }
}
