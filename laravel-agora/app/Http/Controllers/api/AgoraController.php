<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\CallHistory;
use App\Models\User;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control");

class AgoraController extends Controller
{
    public function  __construct()
    {
        $lang = (isset($_POST['language']) && !empty($_POST['language'])) ? $_POST['language'] : 'en';
        App::setlocale($lang);
    } 

     public function generateToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => [
                'required' ,
                Rule::in(['en','hi','ur','bn','ar','in','ms','tr','fa','fr','de','es']),
            ],
            'caller_id'   => 'required||numeric',
            'receiver_id'   => 'required||numeric',
            'call_type' => [
                'required' ,
                Rule::in(['audio','video']),
            ],
            'channel_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => __('msg.Validation Failed!'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {

            $sender = User::where('id', '=', $request->caller_id)->first();
            $reciever = User::where('id', '=', $request->receiver_id)->first();

            $channelName = $request->channel_name;
            $agora  =   GetToken($request->login_id, $channelName);

            if ($agora) {
                $title = $sender->name;
                $body = __('msg.Incoming').' '.$request->call_type.' '. __('msg.Call');

                if (isset($reciever) && !empty($reciever)) {
                    $token = $reciever->fcm_token;
                    $data = array(
                        'notType'        => $request->call_type,
                        'from_user_name' => $sender->name,
                        'from_user_id'   => $sender->id,
                        'to_user_id'     => $reciever->id,
                        'channel_name'   => $agora['channel'],
                        'token'          => $agora['token'],
                    );

                    sendFCMNotifications($token, $title, $body, $data);
                }

                return response()->json([
                    'status'    => 'success',
                    'message'   => __('msg.agora.success'),
                    'channel_name' => $agora['channel'], 
                    'token' => $agora['token']
                ],200);
            }else{
                return response()->json([
                    'status'    => 'failed',
                    'message'   => __('msg.agora.failure'),
                ],400);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => __('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }
    
    public function callHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => [
                'required' ,
                Rule::in(['en','hi','ur','bn','ar','in','ms','tr','fa','fr','de','es']),
            ],
            'caller_id'   => 'required||numeric',
            'receiver_id'   => 'required||numeric',
            'call_type' => [
                'required' ,
                Rule::in(['audio','video']),
            ],
            'call_status' => [
                'required' ,
                Rule::in(['incoming','accepted','rejected']),
            ],
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => __('msg.Validation Failed!'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            $data = [
                'caller_id' => $request->caller_id,
                'receiver_id' => $request->receiver_id,
                'call_type' => $request->call_type,
                'status'    => $request->call_status,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $insert = CallHistory::insert($data);
            if ($insert) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => __('msg.agora.create.success'),
                ],200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => __('msg.agora.create.failure'),
                ],400);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => __('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }
}
