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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
   
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:500',
        ]);
        $validatedData = $validator->validated();
        try {
            $sv = Service::create($validatedData);
            return response()->json([
                'message' => 'Thêm dịch vụ thành công',
                'status' => 'success',
                'data' => $sv,
            ],201);
        }catch(\Exception $e){
            Log::error("Thêm dịch vụ thất bại" . $e->getMessage());
            return response()->json([
                'message' => 'Thêm dịch vụ thất bại',
                'status' => 'error',
            ],500);
        }
    }
    public function update(Request $request,$id_service){
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
        if(!is_numeric($id_service) || $id_service <= 0 || floor($id_service) != $id_service){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $service = Service::find($id_service);
        if(!$service){
            return response()->json([
                'message' => 'Dịch vụ không tồn tại',
                'status' => 'error',
            ],404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:500',
        ]);
        try{
            $service->update($validatedData);
            return response()->json([
                'message' => 'Cập nhật tên dịch vụ thành công',
                'status' => 'success',
                'data' => $service,
            ],200);
        }catch(\Exception $e){
            Log::error("Cập nhật tên dịch vụ thất bại" . $e->getMessage());
            return response()->json([
                'message' => 'Cập nhật tên dịch vụ thất bại',
                'status' => 'error', 
            ],500);
        }
    }
    public function destroy($id_service){
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
        if(!is_numeric($id_service) || $id_service <= 0 || floor($id_service) != $id_service){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $service = Service::find($id_service);
        if(!$service){
            return response()->json([
                'message' => 'Dịch vụ không tồn tại',
                'status' => 'error',
            ],404);
        }
      try {
        $service->delete();
        return response()->json([
            'message' => 'Xóa thành công',
            'status' => 'success',
        ],200);
      }catch(\Exception $e){
        Log::error("Xóa thất bại" . $e->getMessage());
        return response()->json([
            'message' => 'Xóa thất bại',
            'status' => 'error',
        ],500);
      }
    }
    public function get($id_service){
        if(!is_numeric($id_service) || $id_service <= 0 || floor($id_service) != $id_service){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
            ],422);
        }
        $service = Service::find($id_service);
        if(!$service){
            return response()->json([
                'message' => 'Dịch vụ không tồn tại',
                'status' => 'error',
            ],404);
        }
        return response()->json([
            'message' => 'Lấy dữ liệu dịch vụ thành công',
            'status' => 'success',
            'data' => $service,
        ],200);
    }
    public function getAll(){
        $services = Service::all();
        if($services->isEmpty()){
            return response()->json([
                'message' => 'Không có dịch vụ nào',
                'status' => 'success',
                'data' => [],
            ],200);
        }
        return response()->json([
            'message' => 'Lấy danh sách dịch vụ thành công',
            'status' => 'success',
            'data' => $services,
        ],200);
    }
}
