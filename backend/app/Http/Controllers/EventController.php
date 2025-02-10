<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use App\Models\Event;
class EventController extends Controller
{
    public function getEventsOfPool($id_pool){
        $events = Event::where('id_pool',$id_pool)->get();
        if ($events->isEmpty()) {
            return response()->json(['message' => 'Hồ bơi này chưa có sự kiện nào'], 404);
        }
        $events = $events->map(function($event){
            $event->price = (float) $event->price;
            return $event;
        });

        return response()->json($events,200);
    }
    
    public function getEvent($id_pool,$id_event){
        $event = Event::where('id_event',$id_event)->get();
        if($event->isEmpty()){
            return response()->json(['message' => 'Không tìm thấy hồ bơi'],404);
        }
        $event->map(function($event){
            $event->price = (float) $event->price;
            return $event;
        });
        return response()->json($event,200);
    }

    public function events_filter($id_pool,Request $request){
        $events = Event::with('pool')->where('id_pool',$id_pool)
        ->when($request->type,function($query,$type){
            return $query->where('type','=',$type);
        })
        ->when($request->organization_date, function($query, $organization_date) {
            return $query->where('organization_date', '>=', date('Y-m-d H:i:s', strtotime($organization_date)));
        })->get();
        if($events->isEmpty()){
            return response()->json(['message' => 'Không có sự kiện nào'],404);
        }
        $events = $events->map(function($event){
            $event->price = (float) $event->price;
            return $event;
        });
        return response()->json($events,200);
    }
}
