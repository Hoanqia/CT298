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
use App\Models\Utility;
use App\Models\PoolUtility;
class PoolUtilityController extends Controller
{
    public function getUtilitiesOfPool($id_pool){
        if($id_pool <= 0 || !filter_var($id_pool,FILTER_VALIDATE_INT)){
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
        $poolUtilities =  PoolUtility::with('utility')->where('id_pool',$id_pool)->get();
        if($poolUtilities->isEmpty()){
            return response()->json([
                'message' => 'Hồ bơi không có cung cấp tiện ích nào',
                'status' => 'success',
                'data' => [],
            ],200);
        }
       return response()->json([
        'message' => 'Lấy danh sách tiện ích của hồ bơi thành công',
        'status' => 'success',
        'data' => $poolUtilities,
       ],200);
    }
}
