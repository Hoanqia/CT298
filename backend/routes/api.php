<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;

Route::get('/pools', [PoolController::class, 'getPools']);
Route::get('/pools/{id_pool}',[PoolController::class,'getPool']);
Route::get('/searchPools',[PoolController::class,'searchPools']);

// http://127.0.0.1:8000/api/searchPools?lat=10.031333510171228&lng=105.76967204041281&distance=1&maxFee=50000.00&type=Hồ bơi trẻ em

Route::get('/NumberOfPoolsByTypeInDistrict',[PoolController::class,'NumberOfPoolsByTypeInDistrict']);


Route::get('/{id_pool}/EventsOfPool/',[EventController::class,'getEventsOfPool']);
// http://127.0.0.1:8000/api/4/EventsOfPool/

Route::get('/pools/{id_pool}/EventsFilter',[EventController::class,'events_filter']);
// http://127.0.0.1:8000/api/pools/4/EventsFilter?organization_date=2025-05-10%2010:00:00

Route::get('/getEventsOfUser/{phone}',[UserController::class,'getEventsOfUser']);
