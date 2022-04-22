<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appraisal;
use App\Models\Followup;
use App\Models\GroupMeeting;
use App\Models\GroupVisitation;
use App\Models\GroupVisitationLoan;
use App\Models\GroupVisitationMember;
use App\Models\LoanRecovery;
use App\Models\Message;
use App\Models\User;
use App\Models\UserExpense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userExpense = new UserExpense();

        $expenses = $userExpense->getExpensesByUserId(Auth::user()->id);
        
        if(Auth::user()->hasRole('branch manager'))
        $expenses = $userExpense->getUsersBranchExpenses(Auth::user()->profile->branch);

        if(Auth::user()->hasRole('accountant'))
        $expenses = $userExpense->getUsersExpensesAwaitingApproval('branch manager');

        if(Auth::user()->hasRole('finance manager'))
        $expenses = $userExpense->getUsersExpensesAwaitingApproval('accountant');

        if(Auth::user()->hasRole('admin'))
        $expenses = $userExpense->getUserExpenses();

        $pageData = [
			'page_name' => 'groups',
            'title' => 'Expenses Management',
            'activities' => DB::table('activity_type')->get(),
            'expenses' => $expenses,
        ];
        return view('user.user_expenses', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'date' => [
                'required', 
                'string', 
            ],
            'activity_type' => [
                'required',
                'string',
            ],

            'outpost_id' => [
                'required',
                'integer',
            ],

            'user_id' => [
                'required',
                'integer',
            ],
        ]);

        $date = $request->input('date');
        $userId = $request->input('user_id');
        $activityType = $request->input('activity_type');
        
        //MADE CHANGES HERE, RELAXED THIS RULE
        // $expenseExist = UserExpense::getUserExpenseByUserDateType($userId, $date, $activityType);
        // if($expenseExist)
        // return redirect(route('user.expenses.show', $expenseExist->expense_id))->with('danger', 'An expense activity of that specification already exists');

        $user = User::find($request->input('user_id'));
        $activity = DB::table('activity_type')->where('activity_id', $activityType)->first();
        $expense = new UserExpense();
        $expense->user_id = $userId;
        $expense->outpost_id = $request->input('outpost_id');
        $expense->date = $date;
        $expense->activity_type = $activityType;
        $expense->save();

        //Save audit trail
        $activity_type = 'Expense Activity Creation';
        $description = 'Successfully created new expense activity '.$activity->activity_name. ' for '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('user.expenses.show', $expense->expense_id))->with('success', 'New activity expense generated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $approvals = $this->getExpenseApprovers($id);

        $pageData = [
			'page_name' => 'groups',
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
            'meetings' => $meeting->getMeetingsByUserId(Auth::user()->id)
        ];
        if ($expense->activity_id == 1) 
        return view('user.group_visit_expense', $pageData);

        if ($expense->activity_id == 2) 
        return view('user.appraisal_expense', $pageData);

        if ($expense->activity_id == 3) 
        return view('user.recovery_expense', $pageData);

        if ($expense->activity_id == 4) 
        return view('user.followup_expense', $pageData);
        
        return view('user.user_expense', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //return $request;
        $request->validate([
            'date' => [
                'required', 
                'string', 
            ],
        ]);

        $date = $request->input('date');
        $activityType = $request->input('activity_type');

        $expense = UserExpense::find($id);
        $user = User::find($expense->user_id);
        $expense->date = $date;
        $expense->save();

        //Save audit trail
        $activity_type = 'Expense Activity Updation';
        $description = 'Successfully updated expense activity for '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'New activity expense generated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = UserExpense::find($id);
        $expense->delete();
        return back()->with('success', 'Activity expense data deleted successfully');
    }


    public function approveExpense(Request $request, $id)
    {
         //return $request;
        $request->validate([
            'comment' => [
                'required', 
                'string', 
            ],
            'approval_level' => [
                'required', 
                'string', 
            ],
        ]);

        $expenseModel = new UserExpense();
        $expenseData =  $expenseModel->getUserExpenseById($id);

        $approval_level = $request->input('approval_level');
        
        $expense = UserExpense::find($id);
        $user = User::find($expense->user_id);
         
        //Branch manager approval
        if( $approval_level == 'Branch Manager')
        {
            $expense->approver1_status = 1;
            $expense->approver1 = Auth::user()->id;
            $expense->approver1_date = Carbon::now();
            $expense->approver1_msg = $request->input('comment');
        }

        //Accountant approval
        if( $approval_level == 'Accountant')
        {
            $expense->approver2_status = 1;
            $expense->approver2 = Auth::user()->id;
            $expense->approver2_date = Carbon::now();
            $expense->approver2_msg = $request->input('comment');
        }

        //Finance manager approval
        if( $approval_level == 'Finance Manager')
        {
            $expense->approver3_status = 1;
            $expense->approver3 = Auth::user()->id;
            $expense->approver3_date = Carbon::now();
            $expense->approver3_msg = $request->input('comment');
        }

        $expense->save();

        /// Send OTP message
        $message = new Message();
        $systemMessage = 'Your expense '. $expenseData->activity_name.' dated '.$expenseData->date.' has been successfully approved at '.$approval_level. ' level';
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->profile->mobile_no), 2);

        /// Send  email
        $message->SendSystemEmail(ucwords($user->name), $user->email, $systemMessage, $approval_level.' Expense Approval');

        $message->message_status = 'sent'; 
        $message->message_type = 'expense_approval'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //Save audit trail
        $activity_type = $approval_level.' Expense Approval';
        $description = 'Successfully approved expense '. $expenseData->activity_name.' activity for '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Activity Expense has been succesfully approved and sent to the next approver');
    }

    public function rejectExpense(Request $request, $id)
    {
         //return $request;
        $request->validate([
            'comment' => [
                'required', 
                'string', 
            ],
            'approval_level' => [
                'required', 
                'string', 
            ],
        ]);

        $expenseModel = new UserExpense();
        $expenseData =  $expenseModel->getUserExpenseById($id);

        $approval_level = $request->input('approval_level');
        
        $expense = UserExpense::find($id);
        if ($approval_level == 'Accountant') {
            $expense->approver1_status = null;
            $expense->approver1 = null;
            $expense->approver1_date = null;
            $expense->approver1_msg = null;
            
        }else{

            $expense->approver1_status = null;
            $expense->approver1 = null;
            $expense->approver1_date = null;
            $expense->approver1_msg = null;

            $expense->approver2_status = null;
            $expense->approver2 = null;
            $expense->approver2_date = null;
            $expense->approver2_msg = null;
        }
        
        $user = User::find($expense->user_id);
        $expense->save();
        
        /// Send OTP message
        $message = new Message();
        $systemMessage = 'Your expense '. $expenseData->activity_name.' dated '.$expenseData->date.' was rejected at '.$approval_level. ' level with reason : '.ucfirst($request->input('comment'));
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->profile->mobile_no), 2);

        /// Send  email
        $message->SendSystemEmail(ucwords($user->name), $user->email, $systemMessage, $approval_level.' Expense Rejection');

        $message->message_status = 'sent'; 
        $message->message_type = 'expense_rejection'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //Save audit trail
        $activity_type = $approval_level.' Expense Rejection';
        $description = 'Successfully rejected expense '. $expenseData->activity_name.' activity for '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('user.expenses.index'))->with('success', 'Activity Expense has been succesfully rejected and user notified');

    }
    
    public function claimExpenses()
    {
        $userExpense = new UserExpense();
        $expenses = $userExpense->getClaimExpenses();
        $pageData = [
			'page_name' => 'finance',
            'title' => 'Claim Expenses',
            'activities' => DB::table('activity_type')->get(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'expenses' => $expenses,
        ];
        return view('user.claim_expenses', $pageData);
    }

    public function payExpense($id)
    {
         //return $request;
        $expense = UserExpense::find($id);
        $user = User::find($expense->user_id);
        $expense->paid = 1;
        $expense->pay_date = Carbon::now();
        $expense->save();

        //Save audit trail
        $activity_type = 'Paid Expense Activity';
        $description = 'Successfully paid expense activity dated '.$expense->date.' for '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Expense activity marked as paid successfully');
    }

    public function transactions()
    {
        $userExpense = new UserExpense();
        $expenses = $userExpense->getClaimExpenses();
        $pageData = [
			'page_name' => 'finance',
            'title' => 'Transactions',
            'activities' => DB::table('activity_type')->get(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'expenses' => $expenses,
        ];
        return view('user.transactions', $pageData);
    }

    public function getExpenseApprovers($id)
    {
        //// Getting approval details name, email, approval level, status, comment, time
        $approvals = [];
        $bm_approval = UserExpense::getApproverDetails($id, 'branch manager');
        $accountant_approval = UserExpense::getApproverDetails($id, 'accountant');
        $finance_manager = UserExpense::getApproverDetails($id, 'finance manager');
        
        $approvals = [
            'branch_manager' => $bm_approval,
            'accountant' => $accountant_approval,
            'finance_manager' => $finance_manager
        ];
        return $approvals;
    }


    ///////////////END/////////////////
}