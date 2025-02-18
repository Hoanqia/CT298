<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'name',
        'phone',
        'password',
        'role',
    ];
    protected $primaryKey = 'id_user';
    protected $table = 'users';
    public $timestamps = false; 
    public function eventregistrations(){
        return $this->hasMany(EventRegistration::class,'id_user');
    }
    public function reviews(){
        return $this->hasMany(Review::class,'id_user');
    }
}
