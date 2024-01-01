<?php

namespace App\Helper;

class Helper {

    public function Sendfirebasenotification($registration_id,$body,$title)
    {
       
        $server_key = 'AAAAlRh03Qs:APA91bFMBx8-1dHka3Q6IL2JU6-xRvqNlR_oJpbWQ3GzYT2ysJsIiZXiX804L749RTsJV72gfSSAmaBFREV6CspnlZXLfGOX34nhTsal5ydEudB_dnCJx80wyHM56H-ZuzgiGYzMkoJr';

        // $registration_id = json_encode($registration_id);
		 $json_data =[
            "registration_ids"=>$registration_id, "priority"=> "high",
             "data" => [
                 "message" => $body,
                 "title"=> $title,
                 "sound" => "default",
                 "color" => "#ADD8E6"
             ],
             "notification" => [
                "body" => $body,
                 "title"=> $title,
                 "sound" => "default",
                 "color" => "#ADD8E6"
             ]
        ];

        $data = json_encode($json_data);
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
       
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === FALSE) {
        die('Oops! FCM Send Error: ' . curl_error($ch));
        }

        return $data;
            
        curl_close($ch);
    }
}
?>