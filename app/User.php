<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'role_id', 'api_key', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role){
        return $this->role->slug == $role;
    }

    public function isGod(){
        return $this->role->slug == 'god';
    }

    public function isAdmin(){
        return $this->role->slug == 'admin';
    }

    public function isActiveUser(){
        return $this->role->slug == 'user' and $this->active;
        return $this->active;
    }
}
