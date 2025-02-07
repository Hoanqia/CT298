<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;

class PoolController extends Controller
{
    public function getPools()
    {
        $pools = Pool::with('street.ward.district')->get();
        return response()->json($pools, 200);
    }
    public function getPool($id){
    $pool = Pool::with('street.ward.district')->find($id);

    if (!$pool) {
        return response()->json(['message' => 'Không tìm thấy hồ bơi'], 404);
    }

    return response()->json($pool, 200);
}

    
}
