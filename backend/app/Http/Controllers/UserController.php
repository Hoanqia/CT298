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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{    
        public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|regex:/^\+?\d{9,15}$/|unique:users,phone',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            
            if ($errors->has('name')) {
                return response()->json([
                    'message' => 'Tên không hợp lệ!',
                    'error' => $errors->first('name')
                ], 422);
            }

            if ($errors->has('phone')) {
                return response()->json([
                    'message' => 'Số điện thoại không hợp lệ hoặc đã được đăng ký!',
                    'error' => $errors->first('phone')
                ], 422);
            }

            if ($errors->has('password')) {
                return response()->json([
                    'message' => 'Mật khẩu không hợp lệ!',
                    'error' => $errors->first('password')
                ], 422);
            }
        }

        // Mã hóa mật khẩu và tạo user (phải đặt ngoài if để chỉ chạy khi validation thành công)
        $hashedPassword = Hash::make($request->password);
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $hashedPassword,
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công',
        ], 201);
    }
   

    public function login(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:15|regex:/^\+?\d{9,15}$/',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ!',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Kiểm tra thông tin đăng nhập
        if (!Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Số điện thoại hoặc mật khẩu không đúng!',
            ], 401);
        }

        // Lấy thông tin user
        $user = Auth::user();

        // Tạo token đăng nhập
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request){
    // Kiểm tra nếu user đã đăng nhập
    $user = auth('sanctum')->user();
    
    if (!$user) {
        return response()->json(['message' => 'Bạn chưa đăng nhập!'], 401);
    }

    // Xóa token hiện tại
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Đăng xuất thành công!'], 200);
}

    
    public function getEventsOfUser($phone){
        $user = User::where('phone',$phone)->first();
        if(!$user){
            return response()->json(['message' => 'Không tìm thấy người dùng'],404);
        }
        $event_registrations = EventRegistration::with('event')->where('id_user',$user->id_user)->get();
        if($event_registrations->isEmpty()){
            return response()->json(['message','Người dùng chưa đăng ký sự kiện nào']);
        }
        $event_registrations = $event_registrations->map(function($event_registration){
            $event_registration->event->price = (float) $event_registration->event->price;
            return $event_registration;
        });
        return response()->json($event_registrations,200);
    }
    public function EventRegistration($id_pool,$id_event,Request $request){
        $event = Event::where('id_event',$id_event)->first();
        if(!$event){
            return response()->json([
                'message' => 'Sự kiện không tồn tại'
            ],404);
        }
        $user_exist = User::where('phone',$request->phone)->first();
        if(!$user_exist){
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
            EventRegistration::create([
            'id_user' => $user->id_user,
            'id_event' => $id_event,
        ]);
        } else {
                $existing_eventregistration = EventRegistration::where('id_user',$user_exist->id_user)
                ->where('id_event',$id_event)->first();
                if($existing_eventregistration){
                    return response()->json([
                        'message' => 'Người dùng có số điện thoại này đã đăng ký sự kiện này rồi',
                    ],409);
                    } 
                else {
                        EventRegistration::create([
                            'id_user' => $user_exist->id_user,
                            'id_event' => $id_event,
                        ]);
                }
            }
    return response()->json([
        'message' => 'Đăng ký sự kiện thành công',
    ],201);
    }
}
