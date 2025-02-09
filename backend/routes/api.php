<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoolController;

Route::get('/pools', [PoolController::class, 'getPools']);
Route::get('/pools/{id}',[PoolController::class,'getPool']);
Route::get('/searchPools',[PoolController::class,'searchPools']);
Route::get('/NumberOfPoolsByTypeInDistrict',[PoolController::class,'NumberOfPoolsByTypeInDistrict']);