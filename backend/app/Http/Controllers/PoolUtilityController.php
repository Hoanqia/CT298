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
use Illuminate\Support\Facades\Log;
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
    public function getUtilityOfPool($id_pool,$id_pu){
        if(!is_numeric($id_pool) || $id_pool <= 0 || floor($id_pool) != $id_pool){
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
        $utility = PoolUtility::with('utility')->where('id_pool',$pool->id_pool)->where('id_pu',$id_pu)->first();
        if(!$utility){
            return response()->json([
                'message' => 'Không tìm thấy tiện ích của hồ bơi',
                'status' => 'error',
            ],404);
        }
        return response()->json([
            'message' => 'Lấy thông tin tiện ích của hồ bơi thành công',
            'status' => 'success',
            'data' => $utility,
        ],200);
    }

    public function store($id_pool,Request $request){
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
        if(!is_numeric($id_pool) || $id_pool <= 0 || floor($id_pool) != $id_pool){
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
        $validator = Validator::make($request->all(),[
            'id_utility' => 'required|integer|exists:utilities,id_utility',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $validatedData = $validator->validated();
        $validatedData['id_pool'] = $pool->id_pool;
        try {
            $pu = PoolUtility::create($validatedData);
            return response()->json([
                'message' => 'Thêm tiện ích cho hồ bơi thành công',
                'status' => 'success',
                'data' => $pu
            ],201);
        }catch(\Exception $e){
            Log::error("Thêm tiện ích cho hồ bơi thất bại" . $e->getMessage());
            return response()->json([
                'message' => 'Thêm tiện ích cho hồ bơi thất bại',
                'status' => 'error',
            ],500);
        }
    }
    public function destroy($id_pool,$id_pu,Request $request){
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
        if(!is_numeric($id_pool) || $id_pool <= 0 || floor($id_pool) != $id_pool || !is_numeric($id_pu) || $id_pu <= 0 || floor($id_pu) != $id_pu){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $utility = PoolUtility::find($id_pu);
        if(!$utility){
            return response()->json([
                'message' => 'Tiện ích không tồn tại',
                'status' => 'error',
            ],404);
        }
        if(!($utility->delete())){
            return response()->json([
                'message' => 'Xóa tiện ích thất bại',
                'status' => 'error',
            ],500);
        }
        return response()->json([
            'message' => 'Xóa tiện ích thành công',
            'status' => 'success',
        ],200);
    }
}
