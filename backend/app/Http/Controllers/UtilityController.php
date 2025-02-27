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
use App\Models\PoolService;
use App\Models\Service;
use App\Models\Utility;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class UtilityController extends Controller
{
    public function get($id_utility){
        if(!is_numeric($id_utility) || $id_utility <= 0 || floor($id_utility) != $id_utility){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $utility = Utility::find($id_utility);
        if(!$utility){
            return response()->json([
                'message' => 'Tiện ích không tồn tại',
                'status' => 'error',
            ],404);
        }
        return response()->json([
            'message' => 'Lấy thông tin tiện ích thành công',
            'status' => 'success',
            'data' => $utility,
        ],200);
    }
    public function getAll(){
        $utilities = Utility::all();
        if($utilities->isEmpty()){
            return response()->json([
                'message' => 'Chưa có tiện ích',
                'status' => 'success',
                'data' => [],
            ],200);
        }
        return response()->json([
            'message' => 'Lấy danh sách tiện ích thành công',
            'status' => 'success',
            'data' => $utilities,
        ],200);
    }
    public function store(Request $request){
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
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:500',
        ]);
        try {
            $utility = Utility::create($validatedData);
            return response()->json([
                'message' => 'Thêm tiện ích thành công',
                'status' => 'success',
                'data' => $utility,
            ],201);
        }catch(\Exception $e){
            Log::error("Thêm tiện ích thất bại" . $e->getMessage());
            return response()->json([
                'message' => 'Thêm tiện ích thất bại',
                'status' => 'error',
            ],500);
        }
    }
    public function update(Request $request,$id_utility){
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
        if(!is_numeric($id_utility) || $id_utility <= 0 || floor($id_utility) != $id_utility){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $utility = Utility::find($id_utility);
        if(!$utility){
            return response()->json([
                'message' => 'Tiện ích không tồn tại',
                'status' => 'error',
            ],404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:500',
        ]);
        try {
            $utility->update($validatedData);
            return response()->json([
                'message' => 'Cập nhật thông tin thành công',
                'status' => 'success',
                'data' => $utility,
            ],200);
        }catch(\Exception $e){
            Log::error("Cập nhật thông tin tiện ích thất bại" . $e->getMessage());
            return response()->json([
                'message' => 'Cập nhật thông tin tiện ích thất bại',
                'status' => 'error',
            ],500);
        }
    }
    public function destroy($id_utility){
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
        if(!is_numeric($id_utility) || $id_utility <= 0 || floor($id_utility) != $id_utility){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $utility = Utility::find($id_utility);
        if(!$utility){
            return response()->json([
                'message' => 'Tiện ích không tồn tại',
                'status' => 'error',
            ],404);
        }
        try {   
            $utility->delete();
            return response()->json([
                'message' => 'Xóa thành công',
                'status' => 'success'
            ],200);
        }catch(\Exception $e){
            Log::error("Xóa tiện ích thất bại");
            return response()->json([
                'message' => 'Xóa tiện ích thất bại',
                'status' => 'error',
            ],500);
        }
    }
}
