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

    // Chuyển đổi kiểu dữ liệu của giá vé
    $pools = $pools->map(function ($pool) {
        $pool->children_price = (float) $pool->children_price;
        $pool->adult_price = (float) $pool->adult_price;
        $pool->student_price = (float) $pool->student_price;
        return $pool;
    });

    return response()->json($pools, 200);
}

    public function getPool($id){
        $pool = Pool::with('street.ward.district')->find($id);
        if (!$pool) {
        return response()->json(['message' => 'Không tìm thấy hồ bơi'], 404);
    }
    $pool->children_price = (float) $pool->children_price;
    $pool->adult_price = (float) $pool->adult_price;
    $pool->student_price = (float) $pool->student_price;
    return response()->json($pool, 200);
}
    public function searchPools(Request $request){
        $pools = Pool::with('street.ward.district')
        ->when($request->type,function($query,$type){
            return $query->where('type',$type);
        })
        ->when($request->maxFee,function($query,$maxFee){
            return $query->where('children_price','<=',$maxFee)
                        ->orwhere('adult_price','<=',$maxFee)
                        ->orwhere('student_price','<=',$maxFee);
        })
        ->when($request->lat && $request->lng && $request->distance, function($query) use ($request){
            $lat = $request->lat;
            $lng = $request->lng;
            $distance = $request->distance; 
            return $query->selectRaw("*,
                (6371 * acos(cos(radians(?))* cos(radians(lat)) 
                * cos(radians(lng) - radians(?)) + sin(radians(?)) 
                * sin(radians(lat)))) as distance",[$lat,$lng,$lat])
                ->having('distance','<=',$distance)
                ->orderBy('distance','asc');
        })->get();
        if($pools->isEmpty()){
            return response()->json(['message' => 'Không tìm thấy hồ bơi nào trong khoảng cách này']);
        }
        return response()->json($pools,200); 
    }
    
}
