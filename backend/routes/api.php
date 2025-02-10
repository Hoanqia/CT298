<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;

Route::get('/pools', [PoolController::class, 'getPools']); // lấy danh sách tất cả hồ bơi
Route::get('/pools/{id_pool}',[PoolController::class,'getPool']); // lấy thông tin chi tiết của một hồ bơi
Route::get('/pools/search',[PoolController::class,'searchPools']); // tìm hồ bơi 
// http://127.0.0.1:8000/api/searchPools?lat=10.031333510171228&lng=105.76967204041281&distance=1&maxFee=50000.00&type=Hồ bơi trẻ em

Route::get('/pools/statistics',[PoolController::class,'NumberOfPoolsByTypeInDistrict']); // tổng số lượng hồ bơi của quận - tổng số lượng hồ bơi của quận theo loại


Route::get('pools/{id_pool}/events',[EventController::class,'getEventsOfPool']); // lấy danh sách sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/4/EventsOfPool/
Route::get('pools/{id_pool}/events/{id_event}',[EventController::class,'getEvent']); // lấy chi tiết thông tin sự kiện của 1 hồ bơi
Route::get('/pools/{id_pool}/events/filter',[EventController::class,'events_filter']); // lọc sự kiện của 1 hồ bơi
// http://127.0.0.1:8000/api/pools/4/EventsFilter?organization_date=2025-05-10%2010:00:00





Route::post('/pools/{id_pool}/events/{id_event}/register',[UserController::class,'EventRegistration']); // đăng ký sự kiện tại 1 hồ bơi
Route::get('/user/{phone}/events',[UserController::class,'getEventsOfUser']); // lấy danh sách sự kiện mà người dùng đã đăng ký
