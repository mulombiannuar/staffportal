<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\InsurancePolicy;
use App\Models\Message;
use App\Models\SystemProcess;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProcessController extends Controller
{
    public function systemProcesses()
    {
        $pageData = [
          'title' => 'System Processes',
          'page_name' => 'processes',
          'ran_process' => Admin::getRanProcesses(),
          'system_processes' => Admin::getSystemProcesses(),
        ];
        return view('admin.processes', $pageData);
    }

    public function policyExpirationStatus(Request $request)
    {
        $request->validate([
            'date' => [
                'required', 
                'string', 
            ],
            'process_type' => [
                'required',
                'string',
            ],
        ]);
        
       // return $request;
        $date = $request->input('date');
        $process_type = $request->input('process_type');

        try {
            $policies = DB::table('insurance_policies')
                          ->select(
                              'policy_id', 
                              'policy_no', 
                              'date_issued', 
                              'date_expired',
                              'client_phone',
                              'client_name',
                              'status',
                              )
                          ->get();

            $count = 0;
            for ($s=0; $s <count($policies) ; $s++) 
            { 
                $policyDate = $this->checkIsValidDate($policies[$s]->date_expired)? $policies[$s]->date_expired : '2021-03-20';
                if ((new DateTime($date) > new DateTime($policyDate)) && ($policies[$s]->status == 1)) {
                    
                    InsurancePolicy::updatePolicyStatus($policies[$s]->policy_id, 0);

                    //Send notification to client
                    $message = new Message();
                    $systemMessage = ', your insurance policy number '.$policies[$s]->policy_no.' has expired. Please renew it. For assistance, contact 0723209040';
                    $messageBody = $message->getGreetings(strtoupper($policies[$s]->client_name)).' '.$systemMessage;
                    $mobileNo = '2547'.substr(trim($policies[$s]->client_phone), 2);
                
                    //$message->sendSms($mobileNo, $systemMessage);
                    //$message->sendSms('254703539208', $systemMessage);

                    $message->message_status = 'sent'; 
                    $message->message_type = 'policy_alert_client'; 
                    $message->recipient_no = $mobileNo; 
                    $message->recipient_name = $policies[$s]->client_name; 
                    $message->logged_date =  date('D, d M Y H:i:s'); 
                    $message->message_body = $messageBody;
                    $message->save();

                    $count = $count + 1;
                }
            }
        }
        catch (Exception $exception) {
            return back()->with('danger', $exception->getMessage());
            //return back()->withError($exception->getMessage())->withInput();
        }

        $process = new SystemProcess();
        $process->date = $date;
        $process->records = $count;
        $process->name = $process_type;
        $process->user = Auth::user()->id;
        $process->save();

         //Send notification to Admin
         $user = User::getUserById(Auth::user()->id);
         $message = new Message();
         $systemMessage = $process_type.' system process has completed successfully and found and updated ('.$count.') expired records';
         $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
         $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
     
         //$message->sendSms($mobileNo, $systemMessage);
         //$message->sendSms('254703539208', $systemMessage);
 
         $message->message_status = 'sent'; 
         $message->message_type = 'system_process'; 
         $message->recipient_no = $mobileNo; 
         $message->recipient_name = $user->name; 
         $message->logged_date =  date('D, d M Y H:i:s'); 
         $message->message_body = $messageBody;
         $message->save();

        $activity_type = 'System Process';
        $description = 'Successfully ran system process '.$process_type.' dated '.$date;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', $process_type.' system process has completed successfully and found and updated ('.$count.') expired records');
    }

    public function checkIsValidDate($dateString)
    {
        return (bool) strtotime($dateString);
    }
}