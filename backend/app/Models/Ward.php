<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = [
        'id_ward',
        'name',
        'id_district',
    ];
    public $primaryKey = 'id_ward';
    protected $table = 'wards';
    public $timestamps = false ;
    public function streets()
    {
        return $this->hasMany(Street::class, 'id_ward');
    }
    public function district(){
        return $this->belongsTo(District::class, 'id_district');
    }
}
