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
}
