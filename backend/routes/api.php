<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoolController;

// Định nghĩa route API
Route::get('/pools', [PoolController::class, 'getPools']);
Route::get('/pools/{id}',[PoolController::class,'getPool']);