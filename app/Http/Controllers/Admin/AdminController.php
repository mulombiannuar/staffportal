<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AuditTrail;
use App\Models\Group;
use App\Models\GroupMeeting;
use App\Models\Message;
use App\Models\Products\Modem;
use App\Models\Products\Phone;
use App\Models\Role;
use App\Models\User;
use App\Models\UserExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    
   public function index()
   {
      $pageData = [
        'title' => 'Dashboard',
        'page_name' => 'dashboard',
        'stats' => [
          'users' => User::count(),
          'trails' => AuditTrail::count(),
          'messages' => Message::count(),
          'roles' => Role::count(),

          'expenses' => UserExpense::where('user_id', Auth::user()->id)->count(),
          'meetings' => GroupMeeting::where('officer','CAROL')->count(),
          'groups' => Group::where('officer1','JACINTA')->count(),
          
          'transactions' => UserExpense::where('paid',0)->count(),
        ],
      ];
      return view('admin.dashboard', $pageData);
   }

  public function getAccessToken()
  {
    $pageData = ['title' => 'Get Access Token'];
    return view('auth.access-token', $pageData);
  }

  public function auditTrail()
  {
      $pageData = [
        'title' => 'System Audit Trails',
        'page_name' => 'users',
        'trails' => AuditTrail::getTrails()
      ];
      return view('admin.trails', $pageData);
  }


  /**
     * Send access token
    */
  public function sendAccessToken(Request $request)
  {
      $request->validate([
          'mobile_no' => [
              'required',
              'digits:10', 
              'max:10', 
              'min:10',
              'regex:/^([0-9\s\-\+\(\)]*)$/'
          ],
      ]);
      
      $mobile_no = $request->input('mobile_no');
      $user = User::getUserByMobileNumber($mobile_no);
      if (empty($user)) {
          return redirect(route('get.token'))->with('danger', 'We couldnt find any user with that mobile number. Please try again with correct mobile number');
      }

      /// Set session token variable
      $session_token = '123456';
      //$session_token = $this->generateOTP();
      session()->put('access_token', $session_token); 
      session()->put('access_email', $user->email); 
      session()->put('access_name', explode(' ', $user->name)[0]); 

      /// Send OTP message
      $message = new Message();
      $systemMessage = 'Your Access Token code is '.session('access_token');
      $messageBody = $message->getGreetings(strtoupper($user->name)).' '.$systemMessage;
      $mobileNo = '2547'.substr(trim($mobile_no), 2);
      
      //$message->sendSms($mobileNo, $systemMessage);
      //$message->sendSms('254703539208', $systemMessage);

      /// Send OTP mail
     // $message->SendSessionToken(ucwords($user->name), $user->email, session('access_token'));

      $message->message_status = 'sent'; 
      $message->message_type = 'access_token'; 
      $message->recipient_no = $mobileNo; 
      $message->recipient_name = $user->name; 
      $message->logged_date =  date('D, d M Y H:i:s'); 
      $message->message_body = $messageBody;
      $message->save();
      
      $pageData = ['title' => 'Verify Acess Token'];
      return view('auth.verify-token', $pageData);
    
  }

    /**
   * Verify system access token
   */
    public function verifyAccessToken(Request $request)
    {
        $access_token = $request->input('access_token');
        $session_token = session('access_token');
        if ($access_token == $session_token) {
          
           /// Forget session and set new one
           session()->forget('access_token');
           session()->put('session_token', $this->generateOTP()); 
           return redirect(route('login'))->with('success', 'You may proceed to login');
        }
        session()->forget('access_token');
        return back()->with('danger', 'You have entered wrong Access Token!');
    }

    /**
     * Generate OTP
     */
    private function generateOTP()
    {
      $generator = "1357902468"; 
      $result = ""; 
      for ($i = 1; $i <= 6; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
      } 
          return $result; 
    }

      /**
     * Get the sub counties for a county.
     */
    public function fetchSubCounties(Request $request)
    {
        $county_id =  $request->input('county');
        $subs = DB::table('sub_counties')->where('county_id', $county_id)->get();
        $output = '<option value="">- Select Sub County -</option>'; 
        foreach($subs as $row)
        {
          $output .= '<option value="'.$row->sub_id.'">'.$row->sub_name.'</option>';
        }
        return $output; 
    }

    public function fetchBranchUsers(Request $request)
    {
       $branch =  $request->input('branch');
       $users = User::getBranchUsers($branch);
       $output = '';
       if (count($users) == 0) {
         $output .= '<option value="">- No Users found -</option>';
       }else{
          $output .= '<option value="">- Select User below -</option>';
          $output .= '<option value="all"> All Branch Users</option>';
          foreach ($users as $user) 
          {
            $output .= '<option value="'.$user->id.'">'.$user->name.'</option>';
          }
       }
       
       return $output;
    }

    public function fetchOutpostUsers(Request $request)
    {
       $outpost =  $request->input('outpost');
       $users = User::getOutpostUsers($outpost);
       $output = '';
       if (count($users) == 0) {
         $output .= '<option value="">- No Users found -</option>';
       }else{
          $output .= '<option value="">- Select User below -</option>';
          foreach ($users as $user) 
          {
            $output .= '<option value="'.$user->id.'">'.$user->name.'</option>';
          }
       }
       
       return $output;
    }

    public function fetchBranchOutposts(Request $request)
    {
        $branch_id =  $request->input('branch_id');
        $outposts = DB::table('outposts')->where('outpost_branch_id', $branch_id)->get();
        $output = '<option value="">- Select Branch Outpost -</option>'; 
        foreach($outposts as $row)
        {
          $output .= '<option value="'.$row->outpost_id.'">'.$row->outpost_name.'</option>';
        }
        return $output; 
    }

    public function fetchOutpostPhones(Request $request)
    {
       $phone = new Phone();
       $outpost =  $request->input('outpost');
       $users =  $phone->getOutpostPhones($outpost);
       $output = '';
       if (count($users) == 0) {
         $output .= '<option value="">- No Users found -</option>';
       }else{
          $output .= '<option value="">- Select User below -</option>';
          foreach ($users as $user) 
          {
            $output .= '<option value="'.$user->assigned_to.'">'.$user->name.'</option>';
          }
       }
       
       return $output;
    }

    public function fetchOutpostModems(Request $request)
    {
       $modem = new Modem();
       $outpost =  $request->input('outpost');
       $users =  $modem->getOutpostModems($outpost);
       $output = '';
       if (count($users) == 0) {
         $output .= '<option value="">- No Users found -</option>';
       }else{
          $output .= '<option value="">- Select User below -</option>';
          foreach ($users as $user) 
          {
            $output .= '<option value="'.$user->assigned_to.'">'.$user->name.'</option>';
          }
       }
       
       return $output;
    }

}