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
                'message' => 'Chưa có review',
            ],200);
        }
        return response()->json($reviews,200);
    }
    public function create($id_pool, Request $request)
    {
        // 1. Kiểm tra xác thực (lấy user từ token)
        $user = auth('sanctum')->user();
    
        if (!$user) {
            return response()->json([
                'message' => 'Bạn cần đăng nhập để gửi đánh giá!'
            ], 401);
        }
    
        // 2. Kiểm tra hồ bơi có tồn tại không
        $pool = Pool::find($id_pool);
        if (!$pool) {
            return response()->json([
                'message' => 'Hồ bơi không tồn tại!'
            ], 404);
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
        $review = new Review();
        $review->id_user = $user->id_user; // Lấy từ token
        $review->id_pool = $id_pool;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->create_at = now();
    
        $review->save();
    
        return response()->json([
            'message' => 'Đánh giá đã được lưu thành công!',
            'review' => $review,
        ], 201);
    }
    
    
}
