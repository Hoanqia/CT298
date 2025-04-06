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
    Route::delete('/pools/{id_pool}/utilities/{id_pu}',[PoolUtilityController::class,'destroy']); // Xóa tiện ích của 1 hồ bơi
    Route::post('/pools/{id_pool}/utilities/create',[PoolUtilityController::class,'store']); // Thêm tiện ích cho 1 hồ bơi
    Route::delete('/pools/{id_pool}/services/{id_ps}',[PoolServiceController::class,'destroy']); // Chỉnh sửa giá dịch vụ cho 1 hồ bơi
    Route::patch('/pools/{id_pool}/services/{id_ps}',[PoolServiceController::class,'edit']); // Chỉnh sửa giá dịch vụ cho 1 hồ bơi
    Route::post('/pools/{id_pool}/services/create',[PoolServiceController::class,'store']); // Thêm dịch vụ cho 1 hồ bơi
    Route::post('/pools/{id_pool}/reviews/create',[ReviewController::class,'createReview']); // customer đánh giá hồ bơi
    // http://127.0.0.1:8000/api/pools/4/reviews/create?comment=Hồ bơi tệ quá&rating=3 
    
    Route::delete('/users/event-registrations/{id_ER}',[EventRegistrationController::class,'destroy']); // Hủy phiếu đăng ký
   //  http://127.0.0.1:8000/api/users/event-registrations/39
    Route::get('/users/event-registrations/{id_ER}',[EventRegistrationController::class,'getEventRegistrationOfUser']); // Lấy thông tin chi tiết 1 pdk của customer
    // http://127.0.0.1:8000/api/users/event-registrations/39

    Route::get('/users/event-registrations',[EventRegistrationController::class,'getEventRegistrationsOfUser']); // lịch sử đăng ký của customer
    // http://127.0.0.1:8000/api/users/event-registrations/
    Route::patch('/users/update/changePassword',[UserController::class,'changePassword']);
    Route::patch('/users/update',[UserController::class,'update']);

    Route::patch('/pools/{id_pool}/events/{id_event}/event-registrations/{id_ER}',[EventRegistrationController::class,'updateStatusEr']); // Tạo pdk
    Route::post('/pools/{id_pool}/events/{id_event}/event-registrations/create',[EventRegistrationController::class,'createER']); // Tạo pdk
    // http://127.0.0.1:8000/api/pools/15/events/9/event-registrations/create
    Route::get('/pools/{id_pool}/events/{id_event}/event-registrations',[EventRegistrationController::class,'getEventRegistrationsOfEvent']);

    Route::get('/users/reviews/{id_review}',[ReviewController::class,'getReviewOfUser']); // Lấy thông tin chi tiết đánh giá của user 
    // http://127.0.0.1:8000/api/users/reviews/4

    Route::patch('/users/reviews/{id_review}',[ReviewController::class,'updateReview']); // chỉnh sửa đánh giá của user 
    // http://127.0.0.1:8000/api/users/reviews/4

    Route::get('/users/reviews',[ReviewController::class,'getReviewsOfUser']); // lịch sử đánh giá của user
    Route::get('/users/list',[UserController::class,'getAllOfUsers']);
    // http://127.0.0.1:8000/api/users/reviews
    Route::delete('/pools/{id_pool}/events/{id_event}',[EventController::class,'destroy']); // xóa sự kiện của hồ bơi
    Route::patch('/pools/{id_pool}/events/{id_event}',[EventController::class,'updateEvent']); // Cập nhật sự kiện 
    Route::post('/pools/{id_pool}/events/create',[EventController::class,'createEvent']); // Thêm sự kiện cho hồ bơi
    Route::patch('/pools/{id_pool}',[PoolController::class,'updatePool']); // Cập nhật hồ bơi 
    Route::post('/pools/create',[PoolController::class,'createPool']); // Thêm hồ bơi
    Route::delete('/pools/{id_pool}',[PoolController::class,'destroy']); // Xóa hồ bơi

    Route::get('/services/{id_service}',[ServiceController::class,'get']); // Lấy chi tiết thông tin dịch vụ 
    Route::put('/services/{id_service}',[ServiceController::class,'update']); // Cập nhật giá dịch vụ 
    Route::delete('/services/{id_service}',[ServiceController::class,'destroy']); // Xóa dịch vụ
    Route::post('/services/create',[ServiceController::class,'store']); // Thêm dịch vụ
    Route::get('/services',[ServiceController::class,'getAll']);    // Lấy danh sách dịch vụ

    Route::get('/users/',[UserController::class,'getPersonalInformation']); // Lấy thông tin cá nhân của người dùng
    
Route::get('/utilities/{id_utility}',[UtilityController::class,'get']);
Route::patch('/utilities/{id_utility}',[UtilityController::class,'update']);
Route::delete('/utilities/{id_utility}',[UtilityController::class,'destroy']);
Route::post('/utilities',[UtilityController::class,'store']);
Route::get('/utilities',[UtilityController::class,'getAll']);
    Route::post('/logout',[UserController::class,'logout']); // Người dùng đăng xuất 
    // http://127.0.0.1:8000/api/logout
    Route::get('/events',[EventController::class,'getAllofEvents']); // Lấy toàn bộ sự kiện
    Route::get('/event-registrations',[EventRegistrationController::class,'getAll']);
    Route::get('/reviews',[ReviewController::class,'getAll']);
});
    
Route::get('/pools/statistics',[PoolController::class,'NumberOfPoolsByTypeInDistrict']); // tổng số lượng hồ bơi của quận - tổng số lượng hồ bơi của quận theo loại
// http://127.0.0.1:8000/api/pools/statistics


Route::get('/pools/search',[PoolController::class,'searchPools']); // tìm hồ bơi 
// http://127.0.0.1:8000/api/pools/search?type=Hồ bơi tư nhân&maxFee=20000&lat=10.02986040707733&distance=6&lng=105.77074336482

Route::get('/pools/{id_pool}/events/filter',[EventController::class,'events_filter']); // lọc sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/15/events/filter?organization_date=2025-03-10%2008:00:00&type=Thể Thao


Route::get('/pools/{id_pool}/events/{id_event}',[EventController::class,'getEvent']); // lấy chi tiết thông tin sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/15/events/8

Route::get('/pools/{id_pool}/events',[EventController::class,'getEventsOfPool']); // lấy danh sách sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/15/events/

Route::get('/pools/{id_pool}/reviews',[ReviewController::class,'getReviewsOfPool']); // Lấy danh sách đánh giá của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/15/reviews
Route::get('/pools/{id_pool}/services/{id_ps}',[PoolServiceController::class,'getPoolServiceOfPool']); // Lấy thông tin 1 dịch vụ của 1 hồ bơi 
Route::get('/pools/{id_pool}/services',[PoolServiceController::class,'getPoolServicesOfPool']); // Lấy danh sách dịch vụ của 1 hồ bơi 
// http://127.0.0.1:8000/api/pools/15/services
Route::get('/pools/{id_pool}/utilities/{id_pu}',[PoolUtilityController::class,'getUtilityOfPool']); // Lấy thông tin chi tiết tiện ích của 1 hồ bơi
Route::get('/pools/{id_pool}/utilities',[PoolUtilityController::class,'getUtilitiesOfPool']); // Lấy danh sách tiện ích của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/15/utilities

Route::get('/pools/cheapPools',[PoolController::class,'cheapPools']); // Gợi ý hồ bơi rẻ nhất dựa theo tiêu chí ng dùng chọn 
Route::get('/pools/{id_pool}',[PoolController::class,'getPool']); // lấy thông tin chi tiết của một hồ bơi
// http://127.0.0.1:8000/api/pools/15/
Route::get('/pools', [PoolController::class, 'getPools']); // lấy danh sách tất cả hồ bơi
// http://127.0.0.1:8000/api/pools/






Route::get('/districts',[PoolController::class,'getDistrictList']); // lấy danh sách quận huyện
Route::get('/district/{id_district}/wards',[PoolController::class,'getWardList']); // lấy danh sách phường xã theo id quận 
Route::get('/district/{id_district}/wards/{id_ward}/streets',[PoolController::class,'getStreetList']); // lấy danh sách đường xá của phường
Route::post('/register',[UserController::class,'register']); // Đăng ký 
Route::post('/login',[UserController::class,'login']); // Đăng nhập
