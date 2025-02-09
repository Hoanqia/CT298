<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable =[
        'name',
        'description',
        'type',
        'organization_date',
        'max_participants',
        'price',
    ];
    protected $table = 'events';
    protected $primaryKey = 'id_event';
    public $timestamps = false; 

    public function pool(){
        return $this->belongsTo(Pool::class,'id_pool');
    }
    public function EventRegistrations(){
        return $this->hasMany(EventRegistration::class,'id_event');
    }
}
