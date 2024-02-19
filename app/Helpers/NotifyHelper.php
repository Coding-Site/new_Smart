<?php

function sendNotify($fcms,$msg,$title){
   foreach($fcms as $fcm){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "to":"'. $fcm .'",
            "notification": {
            "title": "'. $title .'",
            "body": "'. $msg .'",
            "mutable_content": true,
            "sound": "Tri-tone"
            }

            }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: key='.env('FIREBASE_SERVER_KEY'),
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
   }

}
