<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $table = 'clinics';

    protected $fillable = [
      'user_id', 'name', 'contact', 'email',
      'nif', 'address', 'locality', 'province', 'country',
      'post_code', 'phone', 'fax', 'percentage', 'active',
    ];

    protected $filter = [
      'id', 'user_id', 'name', 'contact', 'email',
      'nif', 'address', 'locality', 'province', 'country',
      'post_code', 'phone', 'fax', 'percentage', 'active', 'created_at',
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function invoices(){
      return $this->hasMany(Invoice::class);
    }
}
