<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;

class PoolController extends Controller
{
    public function getPools(){
    $pools = Pool::with('street.ward.district')->get();

    $pools = $pools->map(function ($pool) {
        $pool->children_price = (float) $pool->children_price;
        $pool->adult_price = (float) $pool->adult_price;
        $pool->student_price = (float) $pool->student_price;
        return $pool;
    });
  return response()->json($pools, 200);
}

    public function getPool($id_pool){
        $pool = Pool::with('street.ward.district')->find($id_pool);
        if (!$pool) {
        return response()->json(['message' => 'Không tìm thấy hồ bơi'], 404);
    }
    $pool->children_price = (float) $pool->children_price;
    $pool->adult_price = (float) $pool->adult_price;
    $pool->student_price = (float) $pool->student_price;
    return response()->json($pool, 200);
}
     
        public function searchPools(Request $request)
        {
            $pools = Pool::with('street.ward.district')
                ->when($request->type, function ($query, $type) {
                    return $query->where('type', $type);
                })
                ->when($request->lat && $request->lng && $request->distance, function ($query) use ($request) {
                    $lat = $request->lat;
                    $lng = $request->lng;
                    $distance = $request->distance;
        
                    return $query->selectRaw(
                        "*, (6371 * acos(cos(radians(?)) * cos(radians(lat)) 
                        * cos(radians(lng) - radians(?)) + sin(radians(?)) 
                        * sin(radians(lat)))) as distance",
                        [$lat, $lng, $lat]
                    )
                    ->having('distance', '<=', $distance)
                    ->orderBy('distance', 'asc');
                });
        
            // Điều kiện maxFee phải được viết riêng để đảm bảo lọc đúng
            if ($request->has('maxFee')) {
                $maxFee = $request->maxFee;
                $pools->where(function ($query) use ($maxFee) {
                    $query->where('children_price', '<=', $maxFee)
                        ->orWhere('adult_price', '<=', $maxFee)
                        ->orWhere('student_price', '<=', $maxFee);
                });
            }
        
            $pools = $pools->get();
        
            if ($pools->isEmpty()) {
                return response()->json(['message' => 'Không tìm thấy hồ bơi nào trong khoảng cách này'], 404);
            }
        
            return response()->json($pools, 200);
        }
        
    public function NumberOfPoolsByTypeInDistrict()
    {
        $poolsByDistrict = Pool::join('streets', 'pools.id_street', '=', 'streets.id_street')
            ->join('wards', 'streets.id_ward', '=', 'wards.id_ward')
            ->join('districts', 'wards.id_district', '=', 'districts.id_district')
            ->select('districts.name as district', 'pools.type', \DB::raw('COUNT(*) as count'))
            ->groupBy('districts.name', 'pools.type')
            ->get();
    
        $groupedData = $poolsByDistrict->groupBy('district')->map(function ($items, $district) {
            return [
                'district' => $district,
                'total_pools' => $items->sum('count'),
                'pools' => $items->map(function ($item) {
                    return [
                        'type' => $item->type,
                        'count' => $item->count
                    ];
                })->values()
            ];
        })->values();
    
        return response()->json($groupedData);
    }
    // public function getEventsOfPool($id_pool){
    //     $events = Event::with('pool')->where('id_pool',$id_pool)->get();
    //     if($events->isEmpty()){
    //         return response()->json(['message' => 'Hồ bơi này chưa có sự kiện nào']);
    //     }
    //     return response()->json($events,200);
    // }

   
    
    
    


}
