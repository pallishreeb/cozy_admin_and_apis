<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;

class PushNotificationController extends Controller
{
    public function sendPushNotification(Request $request)
    {
        $sentToId = $request->input('sentToId');
        $sentByName = $request->input('sentByName');
        $sentById = $request->input('sentById');
        $sentByApp = $request->input('sentByApp');
        $user = null;
        $provider = null;
        if($sentByApp === 'user'){
            $provider = Provider::find($sentToId);
            $user = User::find($sentById);
            // send notification to provider
            $deviceToken = $provider->device_token;
            $this->pushNotification($deviceToken, $sentByName ,$user, $provider);
        }else{
            $user = User::find($sentToId);
            $provider = Provider::find($sentById);
             // send notification to user
             $deviceToken = $user->device_token;
             $this->pushNotification($deviceToken, $sentByName , $user, $provider);
        }

        return response()->json(['message' => 'Push notification sent successfully']);
    }

    public function pushNotification($deviceToken, $sentByName, $user, $provider)
    {
        $data=[];
        $data['message'] = 'You got a new message from  ' . $sentByName;
        $data['user'] = $user;
        $data['provider'] = $provider;
        $response = $this->sendFirebasePush($deviceToken,$data);
    

    }
public function sendFirebasePush($deviceToken, $data)
{
    // Define the FCM server key
    $serverKey = 'AAAAtVkjfnQ:APA91bGUMprWmYo-_ons6GNR9XqnP2ZhfqKubOYbyHSCb1ifFtgD5JK4e_-iJoDvrKeJTEu4SrccCUHCw_LJu9hGNYNRrT5hOUL6le0IWwFKMDG0OAFy9n_cHsTWQJtzpoYzT6ImY9GC';
    
    // Prepare the notification payload
    $notificationData = [
        'body' => $data['message'],
        'title' => 'Cozy App',
    ];

    // Prepare the data payload
    $dataPayload = [
        'message' => $data['message'],
        'type' => "chat",
        'user' => $data['user'],
        'provider' => $data['provider'],
    ];


    // Define the FCM API endpoint
    $url = 'https://fcm.googleapis.com/fcm/send';

    // Prepare the request body
    $fields = [
        'to' => $deviceToken, // for multiple users
        'notification' => $notificationData,
        'data' => $dataPayload,
        'priority' => 'high',
    ];

    // Set the HTTP headers
    $headers = [
        'Content-Type: application/json',
        'Authorization: key=' . $serverKey,
    ];

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    // Execute the cURL request
    $result = curl_exec($ch);

    // Check for cURL errors
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }

    // Close the cURL session
    curl_close($ch);

    // dd($result);
    // Return the result
    return $result;
}
}
