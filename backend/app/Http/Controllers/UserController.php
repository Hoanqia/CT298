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
        $hashedPassword = Hash::make($request->password);
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $hashedPassword,
            'role' => 'customer',
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'status' => 'success',
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
                'status' => 'error',
            ], 401);
        }

        // Lấy thông tin user
        $user = Auth::user();
        // Xóa tất cả token cũ của user
        $user->tokens()->delete();
        // Tạo token đăng nhập
        $token = $user->createToken('authToken')->plainTextToken;
        $user->makeHidden(['password']);

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request){
    // Kiểm tra nếu user đã đăng nhập
    $user = auth('sanctum')->user();
    
    if (!$user) {
        return response()->json(['message' => 'Bạn chưa đăng nhập!','status' => 'error'], 401);
    }

    // Xóa token hiện tại
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Đăng xuất thành công!','status' => 'success'], 200);
}

   
    
}
