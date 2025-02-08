<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    protected $fillable = [
        'id_pool',
        'name',
        'hour_number',
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
    public $timestamps = false ;
    protected $keyType = 'int';

    public function street()
    {
        return $this->belongsTo(Street::class, 'id_street');
    }
}
