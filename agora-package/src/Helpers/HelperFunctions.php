<?php

namespace Noorisys\Agora\Helpers;
use Willywes\AgoraSDK\RtcTokenBuilder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

    function sendFCMNotifications($token, $title, $body, $data)
    {
        $client = new Client();
        $response = $client->post("https://fcm.googleapis.com/fcm/send", [
            'headers' => [
                'Authorization' => 'key=' . env('FCM_KEY'),
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'to' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body
                ],
                'data' => $data
            ]
        ]);
        return $response->getBody()->getContents();
    }

    function GetToken($user_id, $channelName){
    
        $appID         =   Config::get('agora.AGORA_APP_ID');
        $appCertificate    =   Config::get('agora.AGORA_APP_CERTIFICATE');
        $uid = $user_id;
        $uidStr = ($user_id) . '';
        $role = RtcTokenBuilder::RolePublisher;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new \DateTime("now", new \DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
    
        $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
        $data = ['token' => $token, 'channel' => $channelName];
        return $data;
    }

?>