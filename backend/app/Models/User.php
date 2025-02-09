<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'dob',
        'phone'
    ];
    protected $primaryKey = 'id_user';
    protected $table = 'users';
    public $timestamps = false; 
    public function eventregistrations(){
        return $this->hasMany(EventRegistration::class,'id_user');
    }
}
