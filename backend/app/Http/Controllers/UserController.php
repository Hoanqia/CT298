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
    $user = auth('sanctum')->user();
    
    if (!$user) {
        return response()->json(['message' => 'Bạn chưa đăng nhập!','status' => 'error'], 401);
    }

    // Xóa token hiện tại
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Đăng xuất thành công!','status' => 'success'], 200);
}

   
    public function update(Request $request){
        $user = auth('sanctum')->user();
    
        if (!$user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập!','status' => 'error'], 401);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:500',
            'phone' =>  'required|string|max:10',
        ]);
        try {
            $user->update($validatedData);
            $user->makeHidden(['password','role']);
            return response()->json([
                'message' => 'Cập nhật thông tin cá nhân thành công',
                'status' => 'success',
                'data' => $user,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Cập nhật thông tin cá nhân thất bại',
                'status' => 'error',
            ],500);
        }
    }
    public function changePassword(Request $request){
        $user = auth('sanctum')->user();
    
        if (!$user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập!','status' => 'error'], 401);
        }
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Mật khẩu cũ không đúng',
                'status' => 'error'
            ], 400);
        }
        if (!$request->has('new_password_confirmation')) {
            return response()->json([
                'message' => 'Bạn cần nhập lại mật khẩu để xác nhận.',
                'status' => 'error'
            ], 400);
        }
        $validatedData = $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        $hashedPassword = Hash::make($validatedData['new_password']);
        try {
            $user->update([
                'password' => $hashedPassword,
            ]);
    
            return response()->json([
                'message' => 'Thay đổi mật khẩu thành công',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Thay đổi mật khẩu thất bại',
                'status' => 'error',
                'error' => $e->getMessage() 
            ], 500);
        }

    }
    public function getPersonalInformation(){
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập!','status' => 'error'], 401);
        }
        $user->makeHidden(['password','role']);
        return response()->json([
            'message' => 'Lấy thông tin cá nhân thành công',
            'status' => 'success',
            'data' => $user
        ],200);
    }
}
