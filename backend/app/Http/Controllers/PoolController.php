<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
class PoolController extends Controller
{
    public function index()
    {
        $pools = Pool::with('street.ward.district')->get();
        return view('index', compact('pools'));
    }
}
