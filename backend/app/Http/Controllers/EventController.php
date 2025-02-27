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
class EventController extends Controller
{
    public function getEventsOfPool($id_pool){
        $events = Event::where('id_pool',$id_pool)->get();
        if ($events->isEmpty()) {
            return response()->json(['message' => 'Hồ bơi này chưa có sự kiện nào', 'data' => [],'status' => 'success',], 200);
        }
        $events = $events->map(function($event){
            $event->price = (float) $event->price;
            return $event;
        });

        return response()->json([
            'data' => $events,
            'status' => 'success',
            'message' => 'Lấy danh sách sự kiện của hồ bơi thành công',
        ],200);
    }
    
    public function getEvent($id_pool,$id_event){
        $event = Event::where('id_pool',$id_pool)->where('id_event',$id_event)->first();
        if(!$event){
            return response()->json(['message' => 'Không tìm thấy sự kiện trong hồ bơi này', 'data' => null,'status' => 'error',],404);
        }
        $event->price = (float) $event->price;  
        return response()->json([
            'message' => 'Lấy thông tin sự kiện thành công',
            'data' => $event,
            'status' => 'success',
        ],200);
    }

    public function events_filter($id_pool,Request $request){
        $events = Event::where('id_pool',$id_pool)
        ->when($request->filled('type'), function ($query) use ($request) {
            return $query->where('type', '=', $request->type);
        })
        ->when($request->filled('organization_date'), function ($query) use ($request) {
            $timestamp = strtotime($request->organization_date);
            if($timestamp !== false){
                return $query->where('organization_date', '>=', date('Y-m-d H:i:s', $timestamp));
            }
            return $query;
        })->orderBy('organization_date', 'asc')->get();
        if($events->isEmpty()){
            return response()->json([
                'message' => 'Không có sự kiện nào',
                'status' => 'error',
                'data' => [],]
                ,404);
        }
        $events = $events->map(function($event){
            $event->price = (float) $event->price;
            return $event;
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Đã tìm thấy sự kiện', 
            'data' => $events,
        ],200);
    }
    public function createEvent($id_pool,Request $request){
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
        if (!is_numeric($id_pool) || floor($id_pool) != $id_pool || $id_pool <= 0) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
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
            'name' => 'required|string|max:500',
            'description' => 'required|string|max:500',
            'type' =>  'required|in:Thể thao,Party,Giáo dục',
            'organization_date' => 'required|date_format:Y-m-d H:i:s',
            'max_participants' => 'required|numeric|min:10',
            'price' => 'required|numeric|min:0',
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
        $event = Event::create($validatedData);
        if(!$event){
            return response()->json([
                'message' => 'Thêm sự kiện thất bại',
                'status' => 'error',
            ],500);
        }
        return response()->json([
            'message' => 'Thêm sự kiện thành công',
            'status' => 'success',
            'data' => $event,
        ],201);
    }
    public function updateEvent($id_pool,$id_event,Request $request){
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
        if (!is_numeric($id_pool) || !is_numeric($id_event) || (floor($id_pool) != $id_pool)  || (floor($id_event) != $id_event) || $id_event <= 0 || $id_pool <= 0) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
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
        $event = Event::where('id_event',$id_event)->where('id_pool',$pool->id_pool)->first();
        if(!$event){
            return response()->json([
                'message' => 'Sự kiện không tồn tại',
                'status' => 'error',
            ],404);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:500',
            'description' => 'required|string|max:500',
            'type' =>  'required|in:Thể Thao,Party,Giáo dục',
            'organization_date' => 'required|date_format:Y-m-d H:i:s',
            'max_participants' => 'required|numeric|min:10',
            'price' => 'required|numeric|min:0',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'status' => 'error',
                'errors' => $validator->errors(),
            ],422);
        }
        $validatedData = $validator->validated();
        $validatedData['id_pool'] = $event->id_pool;
        $validatedData['id_event'] = $event->id_event;
       
        if(!($event->update($validatedData))){
            return response()->json([
                'message' => 'Cập nhật thông tin sự kiện không thành công',
                'status' => 'error'
            ],500);
        }
        return response()->json([
            'message'=>'Cập nhật thông tin sự kiện thành công',
            'status' => 'success',
        ],200);
    }
    public function destroy($id_pool,$id_event){
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
        if (!is_numeric($id_pool) || !is_numeric($id_event) || (floor($id_pool) != $id_pool)  || (floor($id_event) != $id_event) || $id_event <= 0 || $id_pool <= 0) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
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
        $event = Event::where('id_event',$id_event)->where('id_pool',$pool->id_pool)->first();
        if(!$event){
            return response()->json([
                'message' => 'Sự kiện không tồn tại',
                'status' => 'error',
            ],404);
        }

        if(!($event->delete())){
            return response()->json([
                'message' => 'Xóa sự kiện thất bại',
                'status' => 'error'
            ],500);
        }
        return response()->json([
            'message' => 'Xóa sự kiện thành công',
            'status' => 'success',
        ],200);
    }
}
