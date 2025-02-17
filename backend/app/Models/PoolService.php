<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoolService extends Model
{
    protected $fillable = [
        'id_ps',
        'id_pool',
        'id_service',
        'price',
    ];
    protected $primaryKey = 'id_ps';
    protected $keyType = 'int';
    protected $table = 'pool_services';
    public $timestamps = false;
    public $incrementing = true;

    public function service(){
        return $this->belongsTo(Service::class,'id_service');
    }
    public function pool(){
        return $this->belongsTo(Pool::class,'id_pool');
    }
}
