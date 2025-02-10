<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pool;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use App\Models\Event;
use App\Models\User;
use App\Models\EventRegistration;
class UserController extends Controller
{
    public function getEventsOfUser($phone){
        $user = User::where('phone',$phone)->first();
        if(!$user){
            return response()->json(['message' => 'Không tìm thấy người dùng'],404);
        }
        $event_registrations = EventRegistration::with('event')->where('id_user',$user->id_user)->get();
        if($event_registrations->isEmpty()){
            return response()->json(['message','Người dùng chưa đăng ký sự kiện nào']);
        }
        $event_registrations = $event_registrations->map(function($event_registration){
            $event_registration->event->price = (float) $event_registration->event->price;
            return $event_registration;
        });
        return response()->json($event_registrations,200);
    }
    public function EventRegistration($id_pool,$id_event,Request $request){
        $event = Event::where('id_event',$id_event)->first();
        if(!$event){
            return response()->json([
                'message' => 'Sự kiện không tồn tại'
            ],404);
        }
        $user_exist = User::where('phone',$request->phone)->first();
        if(!$user_exist){
            $user = User::create([
                'name' => $request->name,
                'dob' => $request->dob,
                'phone' => $request->phone,
            ]);
            EventRegistration::create([
            'id_user' => $user->id_user,
            'id_event' => $id_event,
        ]);
        } else {
                $existing_eventregistration = EventRegistration::where('id_user',$user_exist->id_user)
                ->where('id_event',$id_event)->first();
                if($existing_eventregistration){
                    return response()->json([
                        'message' => 'Người dùng có số điện thoại này đã đăng ký sự kiện này rồi',
                    ],409);
                    } 
                else {
                        EventRegistration::create([
                            'id_user' => $user_exist->id_user,
                            'id_event' => $id_event,
                        ]);
                }
            }
    return response()->json([
        'message' => 'Đăng ký sự kiện thành công',
    ],201);
    }
}
