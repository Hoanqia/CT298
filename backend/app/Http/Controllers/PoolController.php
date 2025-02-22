<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class PoolController extends Controller
{
    public function getPools(){
    $pools = Pool::with('street.ward.district')
    ->withAvg('reviews','rating')->withCount('reviews')
    ->get();
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
        $pool->img = asset('storage/' . $pool->img);
        $pool->average_rating = round($pool->reviews_avg_rating,1);
        $pool->total_reviews = $pool->reviews_count; 
        unset($pool->reviews_avg_rating, $pool->reviews_count); 
        return $pool;
    });
  return response()->json([
    'status' => 'success',
    'data' => $pools,
    'message' => 'Lấy danh sách hồ bơi thành công',
  ], 200);
}

    public function getPool($id_pool){
        $pool = Pool::with(['street.ward.district','pool_services.service','pool_utilities.utility'])
        ->withAvg('reviews','rating')->withCount('reviews')
        ->find($id_pool);
        if (!$pool) {
        return response()->json(['message' => 'Không tìm thấy hồ bơi','status' => 'error','data' => null,], 404);
    }
    $pool->children_price = (float) $pool->children_price;
    $pool->adult_price = (float) $pool->adult_price;
    $pool->student_price = (float) $pool->student_price;
    $pool->average_rating = round($pool->reviews_avg_rating,1);
    $pool->total_reviews = $pool->reviews_count; 
    $pool->img = asset('storage/' . $pool->img);
    unset($pool->reviews_avg_rating, $pool->reviews_count); 
    foreach ($pool->pool_services as $service) {
        $service->price = (float) $service->price;
    }
   
    return response()->json([
        'data' => $pool,
        'status' => 'success',
        'message' => 'Lấy thông tin hồ bơi thành công',
    ], 200);
}
     
        public function searchPools(Request $request)
        {
            $pools = Pool::with('street.ward.district')
                ->when($request->filled('type') && $request->type !== "Tất cả", function ($query) use ($request) {
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
            $pools = $pools->map(function ($pool) {
                $pool->children_price = (float) $pool->children_price;
                $pool->adult_price = (float) $pool->adult_price;
                $pool->student_price = (float) $pool->student_price;
                $pool->img = asset('storage/' . $pool->img);
                return $pool;
            });
            
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
  
public function createPool(Request $request){
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'house_number' => 'required|integer',
            'id_street' => 'required|exists:streets,id_street',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'length' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
            'depth' => 'required|numeric|min:1',
            'type' => 'required|in:Hồ bơi công cộng,Hồ bơi tư nhân,Hồ bơi trẻ em,Hồ bơi thi đấu',
            'opening_hours' => 'required|date_format:H:i',
            'close_hours' => 'required|date_format:H:i|after:opening_hours',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'children_price' => 'required|numeric|min:0',
            'adult_price' => 'required|numeric|min:0',
            'student_price' => 'required|numeric|min:0',
        ]);
        
        try {
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('uploads/pools', $imageName, 'public');
                $validatedData['img'] = 'uploads/pools/' . $imageName;
            }

            $pool = Pool::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm hồ bơi thành công',
                'data' => $pool
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
public function updatePool($id_pool,Request $request){
    $user = auth('sanctum')->user();
    if(!$user){
        return response()->json([
            'message' => 'Bạn cần đăng nhập',
            'status' => 'error',
        ],401);
    }
    if($user->role !== "admin"){
        return response()->json([
            'message' => 'Bạn không có quyền chỉnh sửa thông tin hồ bơi',
            'status' => 'error',
        ],403);
    }
    if($id_pool <= 0 || !filter_var($id_pool,FILTER_VALIDATE_INT)){
        return response()->json([
            'message' => 'Dữ liệu không hợp lệ',
            'status' =>  'error',
        ],422);
    }
    $pool = Pool::find($id_pool);
    if(!$pool){
        return response()->json([
            'message' => 'Hồ bơi này không tồn tại',
            'status' => 'error',
        ],404);
    }
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'house_number' => 'required|integer',
        'id_street' => 'required|exists:streets,id_street',
        'lat' => 'required|numeric|between:-90,90',
        'lng' => 'required|numeric|between:-180,180',
        'length' => 'required|numeric|min:1',
        'width' => 'required|numeric|min:1',
        'depth' => 'required|numeric|min:1',
        'type' => 'required|in:Hồ bơi công cộng,Hồ bơi tư nhân,Hồ bơi trẻ em,Hồ bơi thi đấu',
        'opening_hours' => 'required|date_format:H:i',
        'close_hours' => 'required|date_format:H:i|after:opening_hours',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'children_price' => 'required|numeric|min:0',
        'adult_price' => 'required|numeric|min:0',
        'student_price' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Dữ liệu không hợp lệ',
            'status' => 'error',
            'errors' => $validator->errors(),
        ], 422);
    }
    $validatedData = $validator->validated();
    try {
       if ($request->hasFile('img')) {
            if (!empty($pool->img) && Storage::disk('public')->exists($pool->img)) {
                Storage::disk('public')->delete($pool->img);
            }

            $image = $request->file('img'); 
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('uploads/pools', $imageName, 'public');
            $validatedData['img'] = 'uploads/pools/' . $imageName;
        }
        $pool->update($validatedData);
        return response()->json([
            'message' => 'Cập nhật hồ bơi thành công',
            'status' => 'success',
            'data' => $pool,
        ], 200);
        
    }catch(\Exception $e){
        return response()->json([
            'message' => $e->getMessage(),
            'status' => 'error',
        ],500);
    }

}
public function cheapPools(Request $request){
    $ticketType = $request->input('ticket_type');
    $services = $request->input('services', []);
    $userLat = $request->input('lat');
    $userLng = $request->input('lng');

    $validTicketTypes = ['children_price', 'adult_price', 'student_price'];
    if (!in_array($ticketType, $validTicketTypes)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Loại vé không hợp lệ. Chỉ chấp nhận: children_price, adult_price, student_price',
        ], 400);
    }

    if (!$userLat || !$userLng) {
        return response()->json([
            'status' => 'error',
            'message' => 'Không tìm thấy vị trí hiện tại của người dùng',
        ], 400);
    }

    $pools = Pool::select(
        'pools.*',
        DB::raw("pools.$ticketType as ticket_price"),
        DB::raw("(6371 * ACOS(COS(RADIANS($userLat)) * COS(RADIANS(pools.lat)) * COS(RADIANS(pools.lng) - RADIANS($userLng))
         + SIN(RADIANS($userLat)) * SIN(RADIANS(pools.lat)))) AS distance_km")
    )
    ->with(['pool_services' => function ($query) use ($services) {
        if (!empty($services)) {
            $query->whereIn('id_service', $services);
        }
    }])
    ->having('distance_km', '<', 50)
    ->orderBy('ticket_price', 'asc')
    ->orderBy('distance_km', 'asc')
    ->get();

    $pools = $pools->map(function ($pool) use ($services) {
        $filteredServiceCost = $pool->pool_services->sum('price');
        $pool->total_cost = $pool->ticket_price + $filteredServiceCost; 
        $pool->img = asset('storage/' . $pool->img);
        unset($pool->pool_services); 
        return $pool;
    });
    $pools = $pools->sortBy('total_cost');
    return response()->json([
        'status' => 'success',
        'data' => $pools,
        'message' => 'Danh sách hồ bơi rẻ nhất đã được lấy thành công.',
    ], 200);
}
public function destroy($id_pool){
    $user = auth('sanctum')->user();
    if(!$user){
        return response()->json([
            'message' => 'Bạn cần đăng nhập',
            'status' => 'error',
        ],401);
    }
    if($user->role !== "admin"){
        return response()->json([
            'message' => 'Bạn không có quyền truy cập',
            'status' => 'error',
        ],403);
    }
    if(!filter_var($id_pool,FILTER_VALIDATE_INT) || $id_pool <= 0  ){
        return response()->json([
            'message' => 'ID hồ bơi không hợp lệ',
            'status' => 'error',
        ],422);
    }
    $pool = Pool::find($id_pool);
    if(!$pool){
        return response()->json([
            'message' => 'Hồ bơi không tồn tại',
            'status' => 'error',
        ],404);
    }
    if( $pool->delete()){
    return response()->json([
        'message' => 'Xóa hồ bơi thành công',
        'status' => 'success',
    ],200);}
    return response()->json([
        'message' => 'Xóa hồ bơi thất bại',
        'status' => 'error',
    ],500);
}


public function getDistrictList(){
    $districts = District::all();
    if($districts->isEmpty()){
        return response()->json([
            'message' => 'Không có dữ liệu quận huyện',
            'status' => 'success',
            'data' => [],
        ],200);
    }
    return response()->json([
        'message' => 'Lấy dữ liệu quận huyện thành công',
        'status' => 'success',
        'data' => $districts,
    ],200);
}
public function getWardList($id_district){
    $wards = Ward::where('id_district',$id_district)->get();
    if($wards->isEmpty()){
        return response()->json([
            'message' => 'Không có dữ liệu phường xã',
            'status' => 'success',
            'data' => [],
        ],200);
    }
    return response()->json([
        'message' => 'Lấy dữ liệu phường xã thành công',
        'status' => 'success',
        'data' => $wards,
    ],200);
}
public function getStreetList($id_district,$id_ward){
    $streets = Street::where('id_ward',$id_ward)->get();
    if($streets->isEmpty()){
        return response()->json([
            'message' => 'Không có dữ liệu đường xã',
            'status' => 'success',
            'data' => [],
        ],200);
    }
    return response()->json([
        'message' => 'Lấy dữ liệu đường xá thành công',
        'status' => 'success',
        'data' => $streets,
    ],200);
}

}
