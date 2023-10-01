<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'approved',
        'user_type',
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile() {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function user_roles() {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }

    public function project() {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    public function project_user() {
        return $this->hasMany(ProjectUser::class, 'user_id', 'id');
    }

    public function has_role($user_roles, $role_id) {
        foreach ($user_roles as $user_role) {
            if ($user_role->role_id === $role_id)
                return true;
        }
        return false;
    }

    public static function user_approve() {
        $user = Auth::User();
        if ($user->user_type = config('_global.student')) {
            $prof_cnt = $user->profile()->count();
            $user_role_cnt = $user->user_roles()->count();
            $user->approved = ($prof_cnt > 0) and ($user_role_cnt > 0);
            $user->save();
        }
    }
}
