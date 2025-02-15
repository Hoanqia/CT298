<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EventRegistrationController;

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::post('/pools/{id_pool}/reviews/create',[ReviewController::class,'createReview']);
    Route::post('/logout',[UserController::class,'logout']);
    Route::get('/users/event-registrations',[EventRegistrationController::class,'getEventRegistrationsOfUser']);
    Route::post('/pools/{id_pool}/events/{id_event}/event-registration/create',[EventRegistrationController::class,'createER']);
});
    


Route::get('/pools/statistics',[PoolController::class,'NumberOfPoolsByTypeInDistrict']); // tổng số lượng hồ bơi của quận - tổng số lượng hồ bơi của quận theo loại
Route::get('/pools/search',[PoolController::class,'searchPools']); // tìm hồ bơi 
// http://127.0.0.1:8000/api/pools/search?lat=10.029881370747768&lng=105.77074458200029&distance=1&maxFee=50000.00&type=Hồ bơi trẻ em
Route::get('/pools/{id_pool}/events/filter',[EventController::class,'events_filter']); // lọc sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/4/events/filter?organization_date=2025-05-10%2010:00:00
Route::get('/pools/{id_pool}/events/{id_event}',[EventController::class,'getEvent']); // lấy chi tiết thông tin sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/4/events/5
Route::get('/pools/{id_pool}/events',[EventController::class,'getEventsOfPool']); // lấy danh sách sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/4/events   
Route::get('/pools/{id_pool}/reviews',[ReviewController::class,'getReviewsOfPool']); 


Route::get('/pools/{id_pool}',[PoolController::class,'getPool']); // lấy thông tin chi tiết của một hồ bơi
Route::get('/pools', [PoolController::class, 'getPools']); // lấy danh sách tất cả hồ bơi
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
