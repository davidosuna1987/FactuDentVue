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
        'name', 'surnames', 'email', 'nickname', 'nif', 'address',
        'locality', 'province', 'country', 'post_code', 'login_provider',
        'phone', 'password', 'api_key', 'role_id', 'active', 'default_percentage',
        'default_retention', 'pdf_color', 'show_logo', 'show_advertising', 'custom_logo',
        'custom_logo_filename'
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
        return $this->role->slug == 'god' or $this->role->slug == 'admin';
    }

    public function isActiveUser(){
        return $this->active;
    }

    public function activeAndInactiveClinics(){
        return $this->hasMany(Clinic::class);
    }

    public function clinics(){
        return $this->hasMany(Clinic::class)->where('active', true);
    }

    public function invoices(){
        $array_clinics = $this->activeAndInactiveClinics()->pluck('id')->toArray();
        return Invoice::whereIn('clinic_id', $array_clinics);
        // return $this->hasManyThrough(Invoice::class, Clinic::class);
    }

    public function pendingInvoices()
    {
        return $this->invoices()->where('payment_date', null);
    }

    public function canCreateInvoices()
    {
        return $this->name and $this->email and $this->nif and $this->address and $this->locality and $this->province and $this->country and $this->post_code and $this->default_percentage;
    }

    public function customLogoFilePath()
    {
        return $this->custom_logo_filename ? asset('images/custom-logos/'.$this->id.'/'.$this->custom_logo_filename) : null;
    }
}
