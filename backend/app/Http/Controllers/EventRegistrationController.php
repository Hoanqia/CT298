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
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
class EventRegistrationController extends Controller
{
    public function getEventRegistrationsOfUser(){
        $user = auth('sanctum')->user();
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn phải đăng nhập để xem danh sách sự kiện',
            ],401);
        }
        $event_registrations = EventRegistration::with('event')->where('id_user',$user->id_user)->get();
        if($event_registrations->isEmpty()){
            return response()->json([
                'status' => 'success',
                'message' => 'Người dùng chưa đăng ký sự kiện nào',
                'data' => [],
            ],200);
        }
        $event_registrations = $event_registrations->map(function($event_registration){
            $event_registration->event->price = (float) $event_registration->event->price;
            return $event_registration;
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Lấy danh sách đăng ký sự kiện của người dùng thành công',
            'data' => $event_registrations,
        ],200);
        }
    
    public function createER($id_pool,$id_event){
        $user = auth('sanctum')->user();
            if(!$user){
                return response()->json([
                   'message' => 'Bạn cần đăng nhập để đăng ký sự kiện',
                    'status' => 'error',
                ],401);
            }
            if (!is_numeric($id_event) || (int)$id_event <= 0 || !is_numeric($id_pool) || (int)$id_pool <= 0) {
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'status'  => 'error',
                ], 400);
            }
            
            $event = Event::where('id_event',$id_event)->first();
            if(!$event){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sự kiện không tồn tại',
                    'data' => null,
                ],404);
            }
            $existing_er = EventRegistration::where('id_user',$user->id_user)->where('id_event',$event->id_event)->first();
            if($existing_er){
                return response()->json([
                    'message' => 'Bạn đã đăng ký sự kiện này rồi',
                    'status' => 'error',
                ],409);
            }
                    $er = EventRegistration::create([
                        'id_user' => $user->id_user,
                        'id_event' => $event->id_event,
                    ]);
                    $er = EventRegistration::with(['user','event'])->find($er->id_ER);
                    return response()->json([
                        'message' => 'Đăng ký sự kiện thành công',
                        'status' => 'success',
                        'data' => $er,
                    ],201);
        }
}
