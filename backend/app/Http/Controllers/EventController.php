<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use App\Models\Event;
use App\Models\EventRegistration;
class EventController extends Controller
{
    public function getEventsOfPool($id_pool){
        $events = Event::where('id_pool',$id_pool)->get();
        if ($events->isEmpty()) {
            return response()->json(['message' => 'Hồ bơi này chưa có sự kiện nào', 'data' => [],'status' => 'success',], 200);
        }
        $events = $events->map(function($event){
            $event->price = (float) $event->price;
            return $event;
        });

        return response()->json([
            'data' => $events,
            'status' => 'success',
            'message' => 'Lấy danh sách sự kiện của hồ bơi thành công',
        ],200);
    }
    
    public function getEvent($id_pool,$id_event){
        $event = Event::where('id_pool',$id_pool)->where('id_event',$id_event)->first();
        if(!$event){
            return response()->json(['message' => 'Không tìm thấy sự kiện trong hồ bơi này', 'data' => null,'status' => 'error',],404);
        }
        $event->price = (float) $event->price;  
        return response()->json([
            'message' => 'Lấy thông tin sự kiện thành công',
            'data' => $event,
            'status' => 'success',
        ],200);
    }

    public function events_filter($id_pool,Request $request){
        $events = Event::where('id_pool',$id_pool)
        ->when($request->filled('type'), function ($query) use ($request) {
            return $query->where('type', '=', $request->type);
        })
        ->when($request->filled('organization_date'), function ($query) use ($request) {
            $timestamp = strtotime($request->organization_date);
            if($timestamp !== false){
                return $query->where('organization_date', '>=', date('Y-m-d H:i:s', $timestamp));
            }
            return $query;
        })->orderBy('organization_date', 'asc')->get();
        if($events->isEmpty()){
            return response()->json([
                'message' => 'Không có sự kiện nào',
                'status' => 'error',
                'data' => [],]
                ,404);
        }
        $events = $events->map(function($event){
            $event->price = (float) $event->price;
            return $event;
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Đã tìm thấy sự kiện', 
            'data' => $events,
        ],200);
    }

   
}
