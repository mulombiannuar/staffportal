<?php

namespace App\Models;

use App\Mail\SendAccountDetails;
use App\Mail\SendSessionToken;
use App\Mail\SendSystemEmail;
use App\Mail\SendTicketsReport;
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
        if ($time < "12") {
            $greetings = "Good morning " . strtoupper($username);
        } elseif ($time >= "12" && $time < "15") {
            $greetings = "Good afternoon " . strtoupper($username);
        } else {
            $greetings = "Good evening " . strtoupper($username);
        }
        return $greetings;
    }

    public function saveSystemMessage($message_type, $mobile_no, $name, $message, $send_sms)
    {
        $message_body = $this->getGreetings(strtoupper($name)) . ', ' . $message;

        $message = new Message();
        $message->message_status = 'sent';
        $message->message_type = $message_type;
        $message->recipient_no = $mobile_no;
        $message->recipient_name = $name;
        $message->message_body = $message_body;
        $message->logged_date =  date('D, d M Y H:i:s');
        $message->save();

        //if($send_sms) $this->sendSms($mobile_no, $message_body);
        if ($send_sms) $this->sendSms('254703539208', $message_body);
        return true;
    }

    public function sendSms($mobileno, $message_body)
    {
        $sender = 'BIMAS';
        $user_id = '15571';
        $smsGatewayUrl = 'https://api.prsp.tangazoletu.com/?';
        $passkey = '2CFKzjE9K3';


        $textmessage = urlencode($message_body);
        $api_params = 'User_ID=' . $user_id . '&passkey=' . $passkey . '&service=1&sender=' . $sender . '&dest=' . $mobileno . '&msg=' . $textmessage;
        $url = $smsGatewayUrl . $api_params;

        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // grab URL and pass it to the browser
        $response = curl_exec($ch);
        $err = curl_error($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function sendSms2($mobileno, $message_body)
    {
        //https://www.directsms.com.au/api/http/php-code-sample/
        $sender = 'BIMAS';
        $user_id = '15571';
        $smsGatewayUrl = 'https://api.prsp.tangazoletu.com/?';
        $passkey = '2CFKzjE9K3';

        $textmessage = urlencode($message_body);
        $api_params = 'User_ID=' . $user_id . '&passkey=' . $passkey . '&service=1&sender=' . $sender . '&dest=' . $mobileno . '&msg=' . $textmessage;
        $url = $smsGatewayUrl . $api_params;

        file($url);
        return true;
    }

    public function sendSms3($mobileno, $message_body)
    {
        $sender = 'BIMAS';
        $user_id = '15571';
        $smsGatewayUrl = 'https://api.prsp.tangazoletu.com/?';
        $passkey = '2CFKzjE9K3';
        $isError = 0;
        $errorMessage = true;

        $textmessage = urlencode($message_body);
        // $api_params ='User_ID='.$user_id.'&passkey='.$passkey.'&service=1&sender='.$sender.'&dest='.$mobileno.'&msg='.$textmessage;
        // $smsgatewaydata = $smsGatewayUrl.$api_params;
        //$url = $smsgatewaydata;

        $postData = array(
            'User_ID' => $user_id,
            'passkey' => $passkey,
            'service' => 1,
            'sender' => $sender,
            'message' => $textmessage,
            'dest' => $mobileno,
        );

        // create a new cURL resource
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $smsGatewayUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            $isError = true;
            $errorMessage = curl_error($ch);
        }
        return curl_close($ch);
        if ($isError) {
            return array('error' => 1, 'message' => $errorMessage);
        } else {
            return array('error' => 0);
        }
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
        $this->saveSystemMessage('email', $recipient, $name, $message, false);

        $details = ['name' => $name, 'email' => $recipient, 'message' => $message, 'subject' => $subject];
        return Mail::to($recipient)->send(new SendSystemEmail($details));
    }

    public function SendTicketsReportEmail($name, $recipient, $message, $subject, $tickets_data)
    {
        $this->saveSystemMessage('email', $recipient, $name, $message, false);

        $data = ['name' => $name, 'email' => $recipient, 'message' => $message, 'subject' => $subject, 'tickets_data' => $tickets_data];
        return Mail::to($recipient)->send(new SendTicketsReport($data));
    }
}
