<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    protected $fillable = [
        'id_utility',
        'name',
    ];
    protected $primaryKey = 'id_utility';
    protected $keyType = 'int';
    protected $table = 'utilities';
    public $timestamps = false;
    public $incrementing = true;

    public function poolUtilities(){
        return $this->hasMany(poolUtilities::class,'id_utility');
    }
}
