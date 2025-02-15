<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use Illuminate\Support\Facades\DB;
class PoolController extends Controller
{
    public function getPools(){
    $pools = Pool::with('street.ward.district')->get();
    if($pools->isEmpty()){
        return response()->json([
            'status' => 'success',
            'data' => [],
            'message' => 'Không có hồ bơi nào',
        ],200);
    }
    $pools = $pools->map(function ($pool) {
        $pool->children_price = (float) $pool->children_price;
        $pool->adult_price = (float) $pool->adult_price;
        $pool->student_price = (float) $pool->student_price;
        return $pool;
    });
  return response()->json([
    'status' => 'success',
    'data' => $pools,
    'message' => 'Lấy danh sách hồ bơi thành công',
  ], 200);
}

    public function getPool($id_pool){
        $pool = Pool::with('street.ward.district')->find($id_pool);
        if (!$pool) {
        return response()->json(['message' => 'Không tìm thấy hồ bơi','status' => 'error','data' => null,], 404);
    }
    $pool->children_price = (float) $pool->children_price;
    $pool->adult_price = (float) $pool->adult_price;
    $pool->student_price = (float) $pool->student_price;
    return response()->json([
        'data' => $pool,
        'status' => 'success',
        'message' => 'Lấy thông tin hồ bơi thành công',
    ], 200);
}
     
        public function searchPools(Request $request)
        {
            $pools = Pool::with('street.ward.district')
                ->when($request->filled('type'), function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })
                ->when($request->has(['lat','lng','distance']), function ($query) use ($request) {
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
            if ($request->filled('maxFee') && is_numeric($request->maxFee)) {
                $maxFee = $request->maxFee;
                $pools->where(function ($query) use ($maxFee) {
                    $query->where('children_price', '<=', $maxFee)
                        ->orWhere('adult_price', '<=', $maxFee)
                        ->orWhere('student_price', '<=', $maxFee);
                });
            }
        
            $pools = $pools->get();
        
            if ($pools->isEmpty()) {
                return response()->json(['message' => 'Không tìm thấy hồ bơi nào trong khoảng cách này','data' => [],'status' => 'error'], 404);
            }
            
            
            return response()->json([
                'message' => 'Tìm thấy hồ bơi',
                'data' => $pools,
                'status' => 'success',
            ], 200);
        }
        
    public function NumberOfPoolsByTypeInDistrict()
    {
        $poolsByDistrict = Pool::join('streets', 'pools.id_street', '=', 'streets.id_street')
            ->join('wards', 'streets.id_ward', '=', 'wards.id_ward')
            ->join('districts', 'wards.id_district', '=', 'districts.id_district')
            ->select('districts.name as district', 'pools.type', \DB::raw('COUNT(*) as count'))
            ->groupBy('districts.name', 'pools.type')
            ->get();
            
        if($poolsByDistrict->isEmpty()){
            return response()->json([
                'message' => 'Không có hồ bơi',
                'status' => 'success',
                'data' => [],
            ],200);
        }
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
    
        return response()->json([
            'status' => 'success',
            'message' => 'Lấy dữ liệu hồ bơi theo tỉnh và loại hồ bơi thành công',
            'data' => $groupedData,
        ],200);
    }
    

   
    
    
    


}
