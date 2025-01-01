<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class FirebaseService
{
    public static function pushNotification($title, $body, $deviceToken,$image=null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = "AAAAraKNFy0:APA91bFvOviB1kyRu0706ZU-iUqcYiN_uWzdBjRo7unDqvvs-9hgVH8my9FhwUZXdDmTyX0dviYrAu0vM8orwTHXnGw2aLZx41hjHk1Wt5nN12F0kOH3WnZ28RWwf9O7AxOrL0rJtPzr";
        $headers = [
            'Authorization' => "key=$serverKey"
        ];
        
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => 'default',
        ];
        if ($image) {
            $notification['image'] = $image;
        }

        $data = [
            'to' => $deviceToken,
            'notification' => $notification,
            // 'data' => [
            //     'key' => 'value',
            // ],
        ];
        $firebase_response = Http::withHeaders($headers)->post($url, $data);
        // LoggerService::storage($firebase_response);

        // // Handle the response as per your requirements
        // if ($response->successful()) {
        //     // Notification sent successfully
        //     // return response()->json(['message' => 'Notification sent']);
        // } else {
        //     // Error sending notification
        //     // return response()->json(['message' => 'Failed to send notification'], 500);
        // }
    }

    public static function pushNotificationTopic($title, $body, $topic,$image=null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = "AAAAraKNFy0:APA91bFvOviB1kyRu0706ZU-iUqcYiN_uWzdBjRo7unDqvvs-9hgVH8my9FhwUZXdDmTyX0dviYrAu0vM8orwTHXnGw2aLZx41hjHk1Wt5nN12F0kOH3WnZ28RWwf9O7AxOrL0rJtPzr";
        $headers = [
            'Authorization' => "key=$serverKey"
        ];
        
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => 'default',
        ];
        if ($image) {
            $notification['image'] = $image;
        }

        $data = [
            'to' => '/topics/' . $topic,
            'notification' => $notification,
            // 'data' => [
            //     'key' => 'value',
            // ],
        ];
        $firebase_response = Http::withHeaders($headers)->post($url, $data);
        // LoggerService::storage($firebase_response);

        // // Handle the response as per your requirements
        // if ($response->successful()) {
        //     // Notification sent successfully
        //     // return response()->json(['message' => 'Notification sent']);
        // } else {
        //     // Error sending notification
        //     // return response()->json(['message' => 'Failed to send notification'], 500);
        // }
    }
}
