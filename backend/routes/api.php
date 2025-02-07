<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoolController;

// Định nghĩa các route cho API
Route::get('/', [App\Http\Controllers\PoolController::class, 'index']);
