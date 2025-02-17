<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    protected $fillable = [
        'name',
        'house_number',
        'id_street',
        'lat',
        'lng',
        'length',
        'width',
        'depth',
        'type',
        'opening_hours',
        'close_hours',
        'img',
        'children_price',
        'adult_price',
        'student_price',
    ];
    protected $primaryKey = 'id_pool';
    protected $table = 'pools';
    public $timestamps = false ;
    protected $keyType = 'int';
    public $incrementing = true;
    public function street()
    {
        return $this->belongsTo(Street::class, 'id_street');
    }
    public function events(){
        return $this->hasMany(Event::class,'id_pool');
    }
    public function reviews(){
        return $this->hasMany(Review::class,'id_pool');
    }
    public function pool_services(){
        return $this->hasMany(PoolService::class,'id_pool');
    }
    public function pool_utilities(){
        return $this->hasMany(PoolUtility::class,'id_pool');
    }
}
