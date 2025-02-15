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

class ReviewController extends Controller
{
    public function getReviewsOfPool($id_pool){
        $reviews = Review::with(['pool','user'])->where('id_pool',$id_pool)->get();
        if($reviews->isEmpty()){
            return response()->json([
                'status' => 'success',
                'message' => 'Hồ bơi này chưa có review nào',
                'data' => [],
            ],200);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Lấy danh sách review của hồ bơi thành công',
            'data' => $reviews,
        ],200);
    }
    public function createReview($id_pool, Request $request)
    {   
        if (!is_numeric($id_pool) || $id_pool <= 0) {
            return response()->json([
                'message' => 'ID hồ bơi không hợp lệ!',
                'status' => 'error',
            ], 400);
        }
    
        // 1. Kiểm tra xác thực (lấy user từ token)
        $user = auth('sanctum')->user();
    
        if (!$user) {
            return response()->json([
                'message' => 'Bạn cần đăng nhập để gửi đánh giá!',
                'status' => 'error',
            ], 401);
        }
    
        // 2. Kiểm tra hồ bơi có tồn tại không
        $pool = Pool::find($id_pool);
        if (!$pool) {
            return response()->json([
                'message' => 'Hồ bơi không tồn tại!',
                'status' => 'error',
                'data' => null,
            ], 404);
        }
        $existingReview = Review::where('id_user', $user->id_user)
        ->where('id_pool', $id_pool)
        ->first();
            if ($existingReview) {
                return response()->json([
                    'message' => 'Bạn đã đánh giá hồ bơi này rồi!',
                    'status' => 'error',
                ], 400);
            }

        // 3. Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'rating'  => 'required|integer|min:1|max:5',  // Rating phải từ 1 đến 5 sao
            'comment' => 'nullable|string|max:500', // Comment không bắt buộc, tối đa 500 ký tự
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ!',
                'errors'  => $validator->errors(),
            ], 422);
        }
    
        // 4. Tạo review mới
        $review = Review::create([
            'id_user'    => $user->id_user,
            'id_pool'    => $id_pool,
            'rating'     => $request->rating,
            'comment'    => $request->comment ?? "", // Chuyển null thành chuỗi rỗng
            'create_at' => now(),
        ]);

        $review = Review::with(['user', 'pool'])->find($review->id_review);
        $review->user->makeHidden(['password']); 

        return response()->json([
            'message' => 'Đánh giá đã được lưu thành công!',
            'data' => $review,
            'status' => 'success'
        ], 201);
    }
   
}
