<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'id_review',
        'id_pool',
        'id_user',
        'comment',
        'rating',
        'create_at',
    ];
    protected $primaryKey = 'id_review';
    public $keyType = 'int';
    protected $table = 'reviews';
    public $timestamps = false;
    public function pool(){
        return $this->belongsTo(Pool::class,'id_pool');
    }
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
}
