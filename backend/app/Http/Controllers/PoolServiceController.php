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
    public function getPoolServicesOfPool($id_pool){
        if(!is_numeric($id_pool) || floor($id_pool) != $id_pool || $id_pool <= 0 ){
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
    public function getPoolServiceOfPool($id_pool,$id_ps){
        if(!is_numeric($id_pool) || floor($id_pool) != $id_pool || $id_pool <= 0 ||
            !is_numeric($id_ps) || floor($id_ps) != $id_ps || $id_ps <= 0 ){
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
        $poolService = PoolService::with('service')->where('id_pool',$id_pool)->where('id_ps',$id_ps)->first();
        if(!$poolService ){
            return response()->json([
                'message' => 'Dịch vụ hồ bơi không tồn tại',
                'status' => 'error',
            ],404);
        }
        $poolService->price = (float) $poolService->price;
      
        return response()->json([
            'message' => 'Lấy dữ liệu dịch vụ của hồ bơi thành công',
            'status' => 'success',
            'data' => $poolService,
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
        if(!is_numeric($id_pool) || floor($id_pool) != $id_pool || $id_pool <= 0 ){
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
        $validator = Validator::make($request->all(),[
            'id_service' => 'required|integer|exists:services,id_service',
            'price' => 'required|numeric|min:1'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
                'errors' => $validator->errors(),
            ],422);
        }
        $validatedData = $validator->validated();
        $validatedData['id_pool'] = $id_pool;
        try {
            $pu = PoolService::create($validatedData);
            return response()->json([
                'message' => 'Thêm dịch vụ cho hồ bơi thành công',
                'status' => 'success',
                'data' => $pu
            ], 201);
        } catch (\Exception $e) {
            Log::error("Cập nhật giá dịch vụ thất bại: " . $e->getMessage());
            return response()->json([
                'message' => 'Thêm dịch vụ cho hồ bơi thất bại',
                'status' => 'error',
            ], 500);
        }
        }
        public function edit($id_pool,$id_ps,Request $request){
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
            if(!is_numeric($id_ps) || floor($id_ps) != $id_ps || $id_ps <= 0){
                return response()->json([
                    'message' => 'ID dịch vụ không hợp lệ',
                    'status' => 'error',
                ],422);
            }
            $ps = PoolService::find($id_ps);
            if(!$ps){
                return response()->json([
                    'message' => 'Dịch vụ không tồn tại',
                    'status' => 'error',
                ],404);
            }
            $validator = Validator::make($request->all(),[
                'price' => 'required|numeric|min:1',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],422);
            }
            $validatedData = $validator->validated();
            $validatedData['id_pool'] = $id_pool;
            $validatedData['id_ps'] = $id_ps;
            try {
                $ps->update($validatedData);
                return response()->json([
                    'message' => 'Cập nhật giá dịch vụ thành công',
                    'status' => 'success',
                    'data' => $ps,
                ],200);
            }catch(\Exception $e){
                Log::error("Cập nhật giá dịch vụ thất bại: " . $e->getMessage());
                return response()->json([
                    'message' => 'Cập nhật giá dịch vụ thất bại',
                    'status' => 'error',
                ],500);
            }

        }
        public function destroy($id_pool,$id_ps){
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
            if(!is_numeric($id_ps) || floor($id_ps) != $id_ps || $id_ps <= 0){
                return response()->json([
                    'message' => 'ID dịch vụ không hợp lệ',
                    'status' => 'error',
                ],422);
            }
            $ps = PoolService::find($id_ps);
            if(!$ps){
                return response()->json([
                    'message' => 'Dịch vụ không tồn tại',
                    'status' => 'error',
                ],404);
            }
            if(!($ps->delete())){
                return response()->json([
                    'message' => 'Xóa thất bại',
                    'status' => 'error',
                ],500);
            }
            return response()->json([
                'message' => 'Xóa thành công',
                'status' => 'success',
            ],200);
        }
}
