<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class ManageDiscountController extends Controller
{
    public function index()
    {
        $categories = Category::whereNotNull('discount')->get();
        return view('discounts.index', compact('categories'));
    }

    public function create()
    {
       // $category = Category::findOrFail($id);
        $categories = Category::all();
        return view('discounts.create', compact('categories'));
        // Return a view to create a new discount for a category
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        // Find the category
        $category = Category::findOrFail($request->category_id);

        // Update the discount for the category
        $category->discount = $request->discount;
        $category->save();
        // Split the discount value at the decimal point
        //$parts = explode('.', $category->discount);

        // Get the integer part (left part) of the discount value
        //$discountPercentage = $parts[0];
        //$response = $this->pushNotification($category->name,$discountPercentage );
        return redirect()->route('manage_discounts.index')
            ->with('success', 'Discount added successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('discounts.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        // Find the category
        $category = Category::findOrFail($id);

        // Update the discount for the category
        $category->discount = $request->discount;
        $category->save();

        return redirect()->route('manage_discounts.index')
            ->with('success', 'Discount updated successfully');
    }

    public function destroy($id)
    {
        // Find the category
        $category = Category::findOrFail($id);

        // Remove the discount for the category
        $category->discount = null;
        $category->save();

        return redirect()->route('manage_discounts.index')
            ->with('success', 'Discount removed successfully');
    }
    public function pushNotification($category, $discountPercentage)
	    {

	        $data=[];
            $data['message'] = $discountPercentage . '% discount on ' . $category;

	        $data['category']= $category;
            $tokens = [];
	        // Retrieve all device tokens from the users table
            $tokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();
	        $response = $this->sendFirebasePush($tokens,$data);

	    }
    public function sendFirebasePush($tokens, $data)
	    {

	        $serverKey = 'AAAAtVkjfnQ:APA91bH7tOGOaTxU6mKtML0cc8PKZgFkdmWmRS_Cer5n0dvN18xBu0emY5kErSc-3PBAWFsd-UcVRvFe-eWxesGKUcmCgTqHv52v3NymKf_JblUfUYDa_burezzyVBaqS_lP_vP87W';
	        
	        // prep the bundle
	        $msg = array
	        (
	            'message'   => $data['message'],
	            'category' => $data['category'],
	        );

	        $notifyData = [
                 "body" => $data['message'],
                 "title"=> "Cozy App"
            ];

	        $registrationIds = $tokens;
	        
	        if(count($tokens) > 1){
                $fields = array
                (
                    'registration_ids' => $registrationIds, //  for  multiple users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
            }
            else{
                
                $fields = array
                (
                    'to' => $registrationIds[0], //  for  only one users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
            }
	            
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key='. $serverKey;

	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        if ($result === FALSE) 
	        {
	            die('FCM Send Error: ' . curl_error($ch));
	        }
	        curl_close( $ch );
	        return $result;
	    }
}
