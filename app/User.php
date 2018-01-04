<?php

namespace App;

use App\Role;
use App\Clinic;
use App\Invoice;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'surnames',
        'email',
        'username',
        'password',
        'api_key',
        'role_id',
        'active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fullName(){
        return $this->name.' '.$this->surnames;
    }

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

    public function clinics(){
        return $this->hasMany(Clinic::class)->orderBy('name', 'asc')->where('active', true)->get();
    }

    public function paginateClinics($clinics_per_page = 10){
        return $this->hasMany(Clinic::class)->orderBy('name', 'asc')->where('active', true)->paginate($clinics_per_page);
    }

    public function invoices(){
        $array_clinic_ids = $this->hasMany(Clinic::class)->orderBy('name', 'asc')->pluck('id')->toArray();
        return Invoice::whereIn('clinic_id', $array_clinic_ids);
    }
}