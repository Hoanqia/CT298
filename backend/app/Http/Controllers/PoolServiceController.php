<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use App\Models\Event;
use App\Models\User;
use App\Models\EventRegistration;
use App\Models\Review;
use App\Models\Service;
use App\Models\PoolService;
use Illuminate\Support\Facades\Validator;
class PoolServiceController extends Controller
{
    public function getPoolServiceOfPool($id_pool){
        if(!filter_var($id_pool,FILTER_VALIDATE_INT) || $id_pool <= 0 ){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $pool = Pool::where('id_pool',$id_pool)->first();
        if(!$pool){
            return response()->json([
                'message' => 'Hồ bơi không tồn tại',
                'status' => 'error',
            ],404);
        }
        $poolServices = PoolService::with('service')->where('id_pool',$id_pool)->get();
        if($poolServices->isEmpty()){
            return response()->json([
                'message' => 'Hồ bơi không có dịch vụ nào',
                'status' => 'success',
                'data' => [],
            ],200);
        }
        $poolServices->transform(function($poolService){
            $poolService->price = (float) $poolService->price;
            return $poolService;
        });
        return response()->json([
            'message' => 'Lấy danh sách dịch vụ của hồ bơi thành công',
            'status' => 'success',
            'data' => $poolServices,
        ],200);
    }
}
