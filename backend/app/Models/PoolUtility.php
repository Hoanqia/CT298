<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoolUtility extends Model
{
    protected $fillable = [
        'id_pu',
        'id_pool',
        'id_utility',
       
    ];
    protected $primaryKey = 'id_pu';
    protected $keyType = 'int';
    protected $table = 'pool_utilities';
    public $timestamps = false;
    public $incrementing = true;

    public function utility(){
        return $this->belongsTo(Utility::class,'id_utility');
    }
    public function pool(){
        return $this->belongsTo(Pool::class,'id_pool');
    }
}
