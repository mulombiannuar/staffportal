<?php

namespace App\Models;

use App\Mail\SendAccountDetails;
use App\Mail\SendSessionToken;
use App\Mail\SendSystemEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $primaryKey = 'message_id';

    public function getGreetings($username)
    {
        date_default_timezone_set("Africa/Nairobi");
        $greetings = '';
        $time = date("H");
        if ($time < "12") 
        {
            $greetings = "Good morning ".$username;
        }
        elseif ($time >= "12" && $time < "15")
        {
            $greetings = "Good afternoon ".$username;
        }
        else
        {
            $greetings = "Good evening ".$username;
        }
        return $greetings;
    } 

    public function sendSms($mobileno, $message_body)
    {       
        $sender = 'BIMAS';
        $user_id ='15571' ; 
        $smsGatewayUrl = 'https://api.prsp.tangazoletu.com/?';
        $passkey = '2CFKzjE9K3'; 

        $textmessage = urlencode($message_body);
        $api_params ='User_ID='.$user_id.'&passkey='.$passkey.'&service=1&sender='.$sender.'&dest='.$mobileno.'&msg='.$textmessage;
        $smsgatewaydata = $smsGatewayUrl.$api_params;
        $url = $smsgatewaydata;
        
        // create a new cURL resource
        $ch = curl_init();
        
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // grab URL and pass it to the browser
        $output = curl_exec($ch);
        
        // close cURL resource, and free up system resources
        return curl_close($ch);  
    }

     //// Send session website access token
    public function SendSessionToken($name, $recipient, $otp)
    {
        $details = ['name' => $name, 'otp' => $otp];
        return Mail::to($recipient)->send(new SendSessionToken($details));
    }

     //// Send acccount details
     public function SendAccountDetails($name, $recipient, $password)
     {
         $details = ['name' => $name, 'password' => $password];
         return Mail::to($recipient)->send(new SendAccountDetails($details));
     }

     public function SendSystemEmail($name, $recipient, $message, $subject)
     {
         $details = ['name' => $name, 'email' => $recipient, 'message' => $message, 'subject' => $subject];
         return Mail::to($recipient)->send(new SendSystemEmail($details));
     }

    
}