<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'id_service',
        'name',
    ];
    protected $primaryKey = 'id_service';
    protected $keyType = 'int';
    protected $table = 'services';
    public $timestamps = false;
    public $incrementing = true;

    public function poolServices(){
        return $this->hasMany(PoolService::class,'id_service');
    }
    
}
