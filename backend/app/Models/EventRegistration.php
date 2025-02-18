<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'id_user',
        'id_event',
        'create_at',
        'status',
    ];
    protected $table = 'eventregistrations';
    protected $primaryKey = 'id_ER';
    protected $keyType = 'int';
    public $timestamps = false;
    public function event(){
        return $this->belongsTo(Event::class,'id_event');
    }
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
}
