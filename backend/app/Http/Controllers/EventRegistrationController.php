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
use Illuminate\Support\Facades\Validator;
class EventRegistrationController extends Controller
{   

    public function getEventRegistrationsOfEvent($id_pool,$id_event){
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
        $ers = EventRegistration::with('user:id_user,name,phone')->where('id_event',$event->id_event)->get();
        if($ers->isEmpty()){
            return response()->json([
                'message' => 'Chưa có phiếu đăng ký nào',
                'status' => 'success',
                'data' => [],
            ],200);
        }
        return response()->json([
            'message' => 'Lấy danh sách phiếu đăng ký của sự kiện thành công',
            'status' => 'success',
            'data' => $ers,
        ],200);
    }
    public function getEventRegistrationsOfUser(){
        $user = auth('sanctum')->user();
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn phải đăng nhập để xem danh sách sự kiện',
            ],401);
        }
        if($user->role !== 'customer'){
            return response()->json([
                'message' => 'Bạn không có quyền truy cập',
                'status' => 'error',
            ],403);
        }
        $event_registrations = EventRegistration::with(['event.pool' => function($query){
            $query->select('id_pool','name');
        }])->where('id_user',$user->id_user)->get();
        if($event_registrations->isEmpty()){
            return response()->json([
                'status' => 'success',
                'message' => 'Người dùng chưa đăng ký sự kiện nào',
                'data' => [],
            ],200);
        }
        $event_registrations = $event_registrations->map(function($event_registration){
            $event_registration->event->price = (float) $event_registration->event->price;
            return $event_registration;
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Lấy danh sách đăng ký sự kiện của người dùng thành công',
            'data' => $event_registrations,
        ],200);
        }
    
    public function createER($id_pool,$id_event){
        $user = auth('sanctum')->user();
            if(!$user){
                return response()->json([
                   'message' => 'Bạn cần đăng nhập để đăng ký sự kiện',
                    'status' => 'error',
                ],401);
            }

            if($user->role !== 'customer'){
                return response()->json([
                    'message' => 'Bạn không có quyền truy cập',
                    'status' => 'error',
                ],403);
            }
            if (!is_numeric($id_event) || (int)$id_event <= 0 || !is_numeric($id_pool) || (int)$id_pool <= 0) {
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'status'  => 'error',
                ], 400);
            }
            
            $event = Event::where('id_event',$id_event)->first();
            if(!$event){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sự kiện không tồn tại',
                    'data' => null,
                ],404);
            }
            $number_of_recent_participants = EventRegistration::where('id_event',$event->id_event)->count(); 
            if($number_of_recent_participants >= $event->max_participants){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sự kiện đã đủ số người tham gia',
                ],409);
            }
            $existing_er = EventRegistration::where('id_user',$user->id_user)->where('id_event',$event->id_event)->first();
            if($existing_er){
                return response()->json([
                    'message' => 'Bạn đã đăng ký sự kiện này rồi',
                    'status' => 'error',
                ],409);
            }
                    $er = EventRegistration::create([
                        'id_user' => $user->id_user,
                        'id_event' => $event->id_event,
                    ]);
                    $er = EventRegistration::with(['user','event'])->find($er->id_ER);
                    $er->user->makeHidden(['password']); 
                    if (!$er) {
                        return response()->json([
                            'message' => 'Đăng ký sự kiện thất bại!',
                            'status'  => 'error',
                        ], 500);
                    }
                    return response()->json([
                        'message' => 'Đăng ký sự kiện thành công',
                        'status' => 'success',
                        'data' => $er,
                    ],201);
        }

        public function destroy($id_ER){
            $user = auth('sanctum')->user();
            if(!$user){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn cần đăng nhập để xóa phiếu đăng ký sự kiện này',
                ],401);
            }
            if($user->role !== 'customer'){
                return response()->json([
                    'message' => 'Bạn không có quyền truy cập',
                    'status' => 'error',
                ],403);
            }
            $er = EventRegistration::where('id_ER',$id_ER)->where('id_user',$user->id_user)->first();
            if(!$er){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn không có quyền xóa phiếu đăng ký này',
                ],403);
            }
            try {
                $delete_er = $er->delete();
                return response()->json([
                    'message' => 'Xóa phiếu đăng ký sự kiện thành công',
                    'status' => 'success',
                ],200);
            }catch(\Exception $e){
                \Log::error("Lỗi khi xóa phiếu đăng ký sự kiện: " . $e->getMessage());
                return response()->json([
                    'message' => 'Không thể xóa phiếu đăng ký sự kiện',
                        'status' => 'error',
                ],500);
            }
        }
       
       /* public function updateEventRegistration($id_ER,Request $request){
            $user = auth('sanctum')->user();
            if(!$user){
                return response()->json([
                    'message' => 'Bạn cần phải đăng nhập để chỉnh sửa',
                    'status' => 'error',
                ],401);
            }
            if(!is_numeric($id_ER) || $id_ER <= 0){
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'status' => 'error',
                ],401);
            }
            $er = EventRegistration::where('id_ER',$id_ER)->where('id_user',$user->id_user)->first();
            if(!$er){
                return response()->json([
                    'message' => 'Bạn không có quyền chỉnh sửa phiếu đăng ký này',
                    'status' => 'error',
                ],403);
            }
            try {
               if( !is_numeric($request->id_event) || $request->id_event <= 0){
                    return response()->json([
                        'message' => 'Dữ liệu không hợp lệ',
                        'status' => 'error',
                    ],401);
               }
               $number_of_recent_participants = EventRegistration::where('id_event',$request->id_event)->count();
               $event = Event::where('id_event',$request->id_event)->first();
               if(!$event){
                return  response()->json([
                    'message' => 'Sự kiện không tồn tại',
                    'status' => 'error',
                ],404);
               }
               if($number_of_recent_participants >= $event->max_participants){
                return response()->json([
                    'message' => 'Sự kiện bạn chọn đã đủ số người tham gia',
                    'status' => 'error',
                ],409);
               } else {
                $er->update(['id_event' => $request->id_event]);
                $er = EventRegistration::with('event.pool')->where('id_ER',$er->id_ER)->first();
                return response()->json([
                 'message' => 'Chỉnh sửa phiếu đăng ký thành công',
                 'status' => 'success',
                 'data' => $er,
                ],200);
               }
            }catch(\Exception $e){
                \Log::error("Lỗi khi chỉnh sửa phiếu đăng ký sự kiện: " . $e->getMessage());
                return response()->json([
                    'message' => 'Chỉnh sửa phiếu đăng ký thất bại',
                    'status' => 'error',
                ],500);
            }
           
        }*/

        public function getEventRegistrationOfUser($id_ER){
            $user = auth('sanctum')->user();
            if(!$user){
                return response()->json([
                    'message' => 'Bạn cần phải đăng nhập', 
                    'status' => 'error',
                ],401);
            }
            
            if(!is_numeric($id_ER) || $id_ER <= 0 ){
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'status' => 'error',
                ],422);
            }
            if($user->role == "customer"){
                $er = EventRegistration::with('event.pool')->where('id_ER',$id_ER)->where('id_user',$user->id_user)->first();
            } else if($user->role == "admin") {
                $er = EventRegistration::with('event.pool')->where('id_ER',$id_ER)->first();
            } else {
                return response()->json([
                    'message' => 'Bạn không có quyền truy cập',
                    'status' => 'error',
                ],403);
            }
            if(!$er){
                return response()->json([
                    'message' => 'Phiếu đăng ký này không tồn tại',
                    'status' => 'error',
                ],404);
            }
            return response()->json([
                'message' => 'Lấy thông tin phiếu đăng ký thành công',
                'status' => 'success',
                'data' => $er,
            ],200);
        }
        public function updateStatusEr($id_pool,$id_event,$id_ER,Request $request){
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
            if (!is_numeric($id_pool) || !is_numeric($id_event) || (floor($id_pool) != $id_pool)  || (floor($id_event) != $id_event) || $id_event <= 0 || $id_pool <= 0 ||
             !is_numeric($id_ER) || (floor($id_ER) != $id_ER) || $id_ER <= 0 ) {
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
            $er = EventRegistration::find($id_ER);
            if(!$er){
                return response()->json([
                    'message' => 'Phiếu đăng ký không tồn tại',
                    'status' => 'error',
                ],404);
            }
            $validator = Validator::make($request->all(),[
                'status' => 'required|in:pending,confirmed,rejected',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],422);
            }
            $validatedData = $validator->validated();
            if(!($er->update($validatedData))){
                return response()->json([
                    'message' => 'Cập nhật trạng thái phiếu đăng ký thất bại',
                    'status' => 'error',
                ],500);
            }
            return  response()->json([
                'message' => 'Cập nhật trạng thái phiếu đăng ký thành công',
                'status' => 'success',
                'data' => $er,
            ],200);

        }
       
}
