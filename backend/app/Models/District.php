<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'id_district',
        'name',
    ];
    protected $table = 'districts';
    public $primaryKey = 'id_district';
    public $timestamps = false ;
    public function wards(){
        return $this->hasMany(Ward::class, 'id_district');
    }
}
