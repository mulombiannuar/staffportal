<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserExpenseController;
use App\Models\Admin;
use App\Models\Appraisal;
use App\Models\CvpPackage;
use App\Models\Followup;
use App\Models\GroupMeeting;
use App\Models\GroupVisitation;
use App\Models\GroupVisitationLoan;
use App\Models\GroupVisitationMember;
use App\Models\LoanRecovery;
use App\Models\MaintenanceLog;
use App\Models\MotorMaintenance;
use App\Models\PaidPackage;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserExpense;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Mpdf\Mpdf;

class PDFController extends Controller
{
    public function userExpense($id)
    {
        $meeting = new GroupMeeting();
        $userExpense = new UserExpense();
        $groupVisitationLoan = new GroupVisitationLoan();
        $groupVisitationMember = new GroupVisitationMember();
        $expense = $userExpense->getUserExpenseById($id);
        $expenseData = GroupVisitation::getExpenseData($id);

        $appraisalData = [];
        $appraisalData = Appraisal::getAppraisalExpenseData($id);

        $recoveryData = [];
        $recoveryData = LoanRecovery::getRecoveryExpenseData($id);

        $followupData = [];
        $followupData = Followup::getFollowupExpenseData($id);
        
        if(!Auth::user()->hasRole('admin|branch manager|accountant|finance manager'))
        {
            if($expense->user_id != Auth::user()->id) 
            return back()->with('danger', 'You dont have rights to access this resource');
        }

        $expenseDataGroups = [];
        $loansApplied = [];
        $approvals = [];
        $members = [];

        if ($expenseData) 
        {
            $members = $groupVisitationMember->getMembersByActivityType($expenseData->visit_id, $expense->activity_type);
            $loansApplied = $groupVisitationLoan->getLoansAppliedByVisitId($expenseData->visit_id);
            $expenseDataGroups = GroupMeeting::whereIn('meeting_id', json_decode($expenseData->groups))->get();

           
        }

        // Getting approval details 
        $userExpenseController = new UserExpenseController;
        $approvals = $userExpenseController->getExpenseApprovers($id);

        $pageData = [
			'page_name' => 'groups',
            'title' => 'Expense Claim Form',
            'expense' => $expense,

            'expenseData' => $expenseData, 
            'expenseDataGroups' => $expenseDataGroups, 
            'loans' => $loansApplied , 
            'members' => $members, 

            'appraisalData' => $appraisalData,
            'recoveryData' => $recoveryData,
            'followupData' => $followupData,
            
            'approvals' => $approvals,
            'title' => $expense->activity_name.' - '.$expense->date,
        ];
       $html = view('pdfs.user_expense', $pageData);
       $pdf = App::make('dompdf.wrapper');
       $pdf->loadHTML($html);
       $pdf->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
       $pdf->setPaper('A4','portrait');
       return $pdf->stream('Expense-Claim-Form-'.date('d-m-y').'.pdf', array('Attachment' => 0)); 
    }

    public function claimExpenses(Request $request)
    {
        $request->validate([
            'start_date' => [
                'required', 
                'date', 
            ],
            'end_date' => [
                'required', 
                'date', 
            ],
            'branch' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'string',
            ],
            'report_type' => [
                'required',
                'integer',
            ],
        ]);

        $user = [];
        $users = [];
        $expenses = [];
        $branch_id = $request->input('branch');
        $type = $request->input('report_type');
        $user_id = $request->input('user_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $userExpense = new UserExpense();
        
        //return $userExpense->getBranchUsersRecords($branch_id);
        if ($user_id == 'all') 
        {
            if ($type == 1) {
                $users = $userExpense->getBranchUsersRecords($branch_id, $start_date, $end_date);
            } else {
                $expenses = $userExpense->getClaimExpensesByBranchId($branch_id,$start_date, $end_date);
            }
        }else{
            $user = User::getUserById($user_id);
            $expenses = $userExpense->getSingleUserExpenses($user_id, $start_date, $end_date);
        }
        
        $pageData = [
            'page_name' => 'finance',
            'title' => 'Expense Claim Form',
            'user' => $user,
            'users' => $users,
            'expenses' => $expenses,
            'date' => ['start_date' => $start_date, 'end_date' => $end_date],
            'branch' => DB::table('branches')->where('branch_id', $branch_id)->first()
        ];

        if ($user_id == 'all') {
            if ($type == 1){
                $html = view('pdfs.individuals_claim_expenses', $pageData);
            } else {
                $html = view('pdfs.branch_claim_expenses', $pageData);
            }
        } else {
            $html = view('pdfs.single_user_expenses', $pageData);
        }
        
      
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $pdf->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream('Claim-Expenses-Form-'.date('d-m-y').'.pdf', array('Attachment' => 0));
    }

    public function showMaintenanceLogData($id, $product_id)
    {
        $logModel = new MaintenanceLog();
        $approval = [];
        if ($product_id == 1) {
            $view = 'desktop_log';
            $log = MaintenanceLog::getAssetLogById($id, $product_id);
            $user_id = $log->assigned_to;
        }
        elseif ($product_id == 2) {
            $view = 'desktop_log';
            $log = MaintenanceLog::getAssetLogById($id, $product_id);
            $user_id = $log->assigned_to;
        }
        elseif ($product_id == 5) {
            $view = 'motor_log';
            $motorModel = new MotorMaintenance();
            $log = $motorModel->getLogById($id);
            $approval = $motorModel->getApprovalStatus($log->status);
            $user_id = $log->user_id;
        }
        else{
            $view = 'desktop_log';
            $log = MaintenanceLog::getAssetLogById($id, $product_id);
            $user_id = $log->assigned_to;
        }
        
        //return $user_id;
        $pageData = [
			'log' => $log,
            'approval' => $approval,
            'page_name' => 'assets',
            'title' => 'Maintenance Log Sheet',
            'branch' => $logModel->getAssetBranch($user_id)
        ];
        
        $html = view('pdfs.'.$view, $pageData);
        $mpdf = new Mpdf();
        $mpdf->SetHeader('Maintenance Logs Sheet|Bimas Kenya Ltd|{PAGENO}');
        $mpdf->SetFooter('Log sheet printed by '.ucwords(Auth::user()->name).' on '.date('F d, Y h:i:sa'));
        $mpdf->defaultheaderfontsize=10;
        $mpdf->defaultheaderfontstyle='B';
        $mpdf->defaultheaderline=0;
        $mpdf->defaultfooterfontsize=10;
        $mpdf->defaultfooterfontstyle='BI';
        $mpdf->defaultfooterline=0;
        $mpdf->WriteHTML($html);
        return $mpdf->Output('Maintenance-Log-Sheet-'.date('d-m-y-H-h-i-s').'.pdf','I');  
        //$mpdf->Output(); // opens in browser
        //return $mpdf->Output('filename.pdf', \Mpdf\Output\Destination::INLINE);
    }

    public function cvpData(Request $request)
    {
        $request->validate([
            'date' => [
                'required', 
                'date', 
            ],
            'report_type' => [
                'required',
                'integer',
            ],
        ]);

        $paidPackage = new PaidPackage();
        $type = $request->input('report_type');
        $date = $request->input('date');
        $products = $paidPackage->getPaidPackages($date);
        
        $pageData = [
            'page_name' => 'packages',
            'title' => 'Staff CVP Packages',
            'products' => $products,
            'attrbts' => ['date' => $date, 'type' => $type]
        ];
        $html = view('pdfs.cvp_data_filtered', $pageData);
        //$html = view('pdfs.cvp_data', $pageData);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $pdf->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('CVP-Packages-Data-'.$date.'.pdf', array('Attachment' => 0));
    }
    

}