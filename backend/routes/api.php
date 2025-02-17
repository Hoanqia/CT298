<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\PoolServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PoolUtilityController;
use App\Http\Controllers\UtilityController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/pools/{id_pool}/reviews/create',[ReviewController::class,'createReview']); // customer đánh giá hồ bơi
    // http://127.0.0.1:8000/api/pools/4/reviews/create?comment=Hồ bơi tệ quá&rating=3 
    
    Route::delete('/users/event-registrations/{id_ER}',[EventRegistrationController::class,'destroy']); // Hủy phiếu đăng ký
    Route::get('/users/event-registrations/{id_ER}',[EventRegistrationController::class,'getEventRegistrationOfUser']); // Lấy thông tin chi tiết 1 pdk của customer
    Route::get('/users/event-registrations',[EventRegistrationController::class,'getEventRegistrationsOfUser']); // lịch sử đăng ký của customer

    Route::post('/pools/{id_pool}/events/{id_event}/event-registration/create',[EventRegistrationController::class,'createER']); // Tạo pdk
    Route::get('/users/reviews/{id_review}',[ReviewController::class,'getReviewOfUser']); // Lấy thông tin chi tiết đánh giá của user 
    Route::patch('/users/reviews/{id_review}',[ReviewController::class,'updateReview']); // chỉnh sửa đánh giá của user 
    Route::get('/users/reviews',[ReviewController::class,'getReviewsOfUser']); // lịch sử đánh giá của user

    Route::post('/logout',[UserController::class,'logout']); // Người dùng đăng xuất 

});
    
Route::get('/pools/statistics',[PoolController::class,'NumberOfPoolsByTypeInDistrict']); // tổng số lượng hồ bơi của quận - tổng số lượng hồ bơi của quận theo loại

Route::get('/pools/search',[PoolController::class,'searchPools']); // tìm hồ bơi 
//http://127.0.0.1:8000/api/pools/search?type=Hồ bơi tư nhân&maxFee=20000&lat=10.02986040707733&distance=6&lng=105.77074336482

Route::get('/pools/{id_pool}/events/filter',[EventController::class,'events_filter']); // lọc sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/4/events/filter?organization_date=2025-05-10%2010:00:00

Route::get('/pools/{id_pool}/events/{id_event}',[EventController::class,'getEvent']); // lấy chi tiết thông tin sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/4/events/5

Route::get('/pools/{id_pool}/events',[EventController::class,'getEventsOfPool']); // lấy danh sách sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/4/events   

Route::get('/pools/{id_pool}/reviews',[ReviewController::class,'getReviewsOfPool']); // Lấy danh sách đánh giá của 1 hồ bơi

Route::get('/pools/{id_pool}/services',[PoolServiceController::class,'getPoolServiceOfPool']); // Lấy danh sách dịch vụ của 1 hồ bơi 
Route::get('/pools/{id_pool}/utilities',[PoolUtilityController::class,'getUtilitiesOfPool']); // Lấy danh sách tiện ích của 1 hồ bơi

Route::get('/pools/{id_pool}',[PoolController::class,'getPool']); // lấy thông tin chi tiết của một hồ bơi
Route::get('/pools', [PoolController::class, 'getPools']); // lấy danh sách tất cả hồ bơi
Route::post('/register',[UserController::class,'register']); // Đăng ký 
Route::post('/login',[UserController::class,'login']); // Đăng nhập
