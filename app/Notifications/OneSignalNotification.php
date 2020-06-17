<?php

namespace App\Notifications;

class OneSignalNotification {

    public static function send($content, $heading, $data, $subtitle, $media, $id){
        $content = array(
            "en" => $content
        );

        $heading = array(
            "en" => $heading
        );

        $subtitles = array(
            "en" => $subtitle
        );

        $app_id = env('ONESIGNAL_APPID', '');
        $rest_id = env('ONESIGNAL_RESTID', '');

        $fields = array(
            'app_id' => $app_id,
            'included_segments' => array("All"),
            'data' => array("data" => $data),
            'contents' => $content,
            'headings' => $heading,
            'subtitle' => $subtitles,
            'ios_attachments' => array("id1" => $media),
            'content_available'=>True,
            'url'=>'ipsupplyNewitem://ebay/'.$id
        );

        $fields = json_encode($fields);

        $header =  array(
            'Content-Type: application/json; charset=utf-8',
            "Authorization: Basic $rest_id"
            );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
