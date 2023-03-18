<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Models\User;
use App\Models\Notification;

define('API_ACCESS_KEY', 'AAAAcQG3dk:APA91bETMjI25KHVyCiBUEakMyrOCst2S7rQ2EakLqvxVs0ix2EXHC2uZRhf5vHfLM9xYfvE4LP1GmMAInDH0s_PguIZFW2-Gxy2sSHQgxrR3LSAUzhhHgFFpVBvqMJgIIQ7s1HWL2DK');

class NotificationMethods
{
    /**
     * @param $user
     * @param $title
     * @param $desc
     * @param $order_id
     * @return Exeption|bool|\Exception|string
     */
    public static function senNotification($user, $title, $desc, $order_id, $save = 0)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = array(
            'body' => $desc,
            'title' => $title,
            'vibrate' => 1,
            'sound' => 1,
            'click_action' => "",
            'status' => "1",
            'order_id' => $order_id,
        );
        $fields = array(
            'to' => $user->fire_base,
            'data' => $msg,
            'notification' => $msg,
        );
        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-type: Application/json'
        );
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
        } catch (Exeption $e) {
            return $e;
        }
        if ($save == 1)
            NotificationMethods::saveNotification($title, $desc, $user->id);
        return $result;
    }

    /**
     * @param $title
     * @param $desc
     * @param $user_id
     * @param $order_id
     * @return Notification
     */
    public static function saveNotification($title, $desc, $user_id)
    {
        $notification = new Notification();
        $notification->title = $title;
        $notification->desc = $desc;
        $notification->user_id = $user_id;
        $notification->save();
        return $notification;
    }
}
