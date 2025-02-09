<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $fillable = [
        'id_street',
        'name',
        'id_ward'
    ];
    protected $table = 'streets';
    public $primaryKey = 'id_street';
    public $timestamps = false ;
    public function pools()
    {
        return $this->hasMany(Pool::class, 'id_street');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'id_ward');
    }
}
