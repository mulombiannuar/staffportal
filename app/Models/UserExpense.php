<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class UserExpense extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_expenses';
    protected $primaryKey = 'expense_id';

    public function getUserExpenses()
    {
        $expenses =  DB::table('user_expenses')
                        ->leftJoin('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                        ->join('users', 'users.id', '=', 'user_expenses.user_id')
                        ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                        ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                        ->select(
                                'user_expenses.*',
                                'activity_type.*',
                                'outposts.outpost_name',
                                'branches.branch_name',
                                'users.name',
                            )
                        ->where('user_expenses.deleted_at', null)
                        ->orderBy('expense_id', 'desc')
                        ->get();
        $this->getExpensesProperties($expenses);                
        return $expenses;
    }

    public function getExpensesByUserId($id)
    {
        $expenses =   DB::table('user_expenses')
                        ->join('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                        ->join('users', 'users.id', '=', 'user_expenses.user_id')
                        ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                        ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                        ->select(
                                'user_expenses.*',
                                'activity_type.*',
                                'outposts.outpost_name',
                                'branches.branch_name',
                                'users.name',
                            )
                        ->where('user_expenses.deleted_at', null)
                        ->where('user_expenses.user_id', $id)
                        ->orderBy('expense_id', 'desc')
                        ->get();
        $this->getExpensesProperties($expenses);                
        return $expenses;
    }

    public function getUserExpenseById($id)
    {
        return  DB::table('user_expenses')
                   ->leftJoin('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                   ->join('users', 'users.id', '=', 'user_expenses.user_id')
                   ->join('profiles', 'profiles.user_id', '=', 'users.id')
                   ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                   ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                   ->select(
                        'user_expenses.*',
                        'activity_type.*',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'profiles.mobile_no',
                        'users.email',
                        'users.name',
                       )
                   ->where('user_expenses.deleted_at', null)
                   ->where('expense_id', $id)
                   ->orderBy('expense_id', 'desc')
                   ->first();
    }

    public function getUsersBranchExpenses($id)
    {
        $expenses =  DB::table('user_expenses')
                   ->leftJoin('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                   ->join('users', 'users.id', '=', 'user_expenses.user_id')
                   ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                   ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                   ->select(
                        'user_expenses.*',
                        'activity_type.*',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'users.name',
                       )
                   ->where('user_expenses.deleted_at', null)
                   ->where('branches.branch_id', $id)
                   ->orderBy('expense_id', 'desc')
                   ->get();
                   
        $this->getExpensesProperties($expenses);
        return $expenses;
    }

    public function getUsersExpensesAwaitingApproval($level)
    {
        if ($level == 'accountant') {
            $approval = ['approver1_status' => 1];
        } 
        elseif($level == 'branch manager') {
            $approval = ['approver2_status' => null];
        }
        elseif($level == 'finance manager') {
            $approval = ['approver3_status' => 1];
        }
        elseif($level == 'approved'){
            $approval = ['approver1_status' => 1, 'approver2_status' => 1, 'approver3_status' => 1];
        }
        
        $expenses =  DB::table('user_expenses')
                   ->leftJoin('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                   ->join('users', 'users.id', '=', 'user_expenses.user_id')
                   ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                   ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                   ->select(
                        'user_expenses.*',
                        'activity_type.*',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'users.name',
                       )
                   ->where('user_expenses.deleted_at', null)
                   ->where($approval)
                   ->orderBy('expense_id', 'desc')
                   ->get();
                   
        $this->getExpensesProperties($expenses);
        return $expenses;
    }

    public static function getUserExpenseByUserDateType($id, $date, $type)
    {
        return  DB::table('user_expenses')
                   ->leftJoin('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                   ->join('users', 'users.id', '=', 'user_expenses.user_id')
                   ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                   ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                   ->select(
                        'user_expenses.*',
                        'activity_type.*',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'users.name',
                       )
                   ->where([
                       'activity_type' => $type,
                       'user_id' => $id,
                       'user_expenses.deleted_at' => null
                       ])
                   ->orderBy('expense_id', 'desc')
                   ->first();
    }

    public static function getApproverDetails($id , $level)
    {
        $field = 'approver1';
        if ($level == 'branch manager') {
            $field = 'approver1';
        } elseif($level == 'accountant') {
            $field = 'approver2';
        } elseif($level == 'finance manager'){
            $field = 'approver3';
        }
        
        return  DB::table('user_expenses')
                   ->join('users', 'users.id', '=', 'user_expenses.'.$field)
                   ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                   ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                   ->select(
                        'user_expenses.*',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'users.name',
                        'users.email'
                    )
                   ->where('user_expenses.deleted_at', null)
                   ->where('expense_id', $id)
                   ->orderBy('expense_id', 'desc')
                   ->first();
    }

    private function getExpenseApprovalStatus($id)
    {
        $status =  'Pending approval at Branch Manager level';
        $expense = UserExpense::find($id);
        // if($expense->approver1_status == 1 && is_null($expense->approver2) && is_null($expense->approver3)){
        //     $status = 'Pending approval at Branch Manager level';
        // }
        if($expense->approver1_status == 1 && $expense->approver2_status == 1 && $expense->approver3_status == 1 && $expense->paid == 1){
            $status = 'Disbursment made. Payment settled';
        }elseif(is_null($expense->approver2) && $expense->approver1_status == 1 && is_null($expense->approver3)){
            $status = 'Approved at Branch Manager level. Pending approval at Accountant level';
        }elseif(is_null($expense->approver3) && $expense->approver1_status == 1 && $expense->approver2_status == 1){
            $status = 'Approved at Accountant level. Pending approval at Finance Manager level';
        }elseif($expense->approver1_status == 1 && $expense->approver2_status == 1 && $expense->approver3_status == 1){
            $status = 'Expense approved, pending disbursment from Finance';
        }elseif($expense->approver3_status == 0 && $expense->approver1_status == 1 && $expense->approver2_status == 1){
            $status = 'Expense rejected at Finance manager level. ';
        }
        return $status;
    }

    public function getClaimExpenses()
    {
        $expenses =  DB::table('user_expenses')
                        ->join('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                        ->join('users', 'users.id', '=', 'user_expenses.user_id')
                        ->join('profiles', 'profiles.user_id', '=', 'users.id')
                        ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                        ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                        ->select(
                                'user_expenses.*',
                                'activity_type.*',
                                'outposts.outpost_name',
                                'branches.branch_name',
                                'branches.branch_id',
                                'profiles.mobile_no',
                                'users.name',
                            )
                        ->where(['approver3_status' =>1,'user_expenses.deleted_at' => null])
                        ->orWhere(['paid' => 1])
                        ->orderBy('name', 'asc')
                        ->get();
        $this->getExpensesProperties($expenses);                
        return $expenses;
    }

    public function getClaimExpensesByBranchId($id, $start_date, $end_date)
    {
        $expenses =  DB::table('user_expenses')
                        ->join('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                        ->join('users', 'users.id', '=', 'user_expenses.user_id')
                        ->join('profiles', 'profiles.user_id', '=', 'users.id')
                        ->join('outposts', 'outposts.outpost_id', '=', 'user_expenses.outpost_id')
                        ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                        ->select(
                                'user_expenses.*',
                                'activity_type.*',
                                'outposts.outpost_name',
                                'branches.branch_name',
                                'branches.branch_id',
                                'profiles.mobile_no',
                                'users.name',
                            )
                        ->where([
                            'branch_id' => $id,
                            'paid' => 1,
                            'approver3_status' =>1,
                            'user_expenses.deleted_at' => null
                            ])
                        ->where('user_expenses.date', '>=', $start_date)
                        ->where('user_expenses.date', '<=', $end_date)
                        ->orderBy('name', 'asc')
                        ->get();
        $this->getExpensesProperties($expenses);                
        return $expenses;
    }

    public function getBranchUsersRecords($id, $start_date, $end_date)
    {
        $users = User::getBranchUsers($id);
        for ($s=0; $s <count($users) ; $s++) 
        { 
            $users[$s]->expenses = [];
            $users[$s]->expenses = $this->getSingleUserExpenses($users[$s]->id, $start_date, $end_date);
        }                
        return $users;
    }

    public function getSingleUserExpenses($id, $start_date, $end_date)
    {
        $expenses =  DB::table('user_expenses')
                    ->join('activity_type', 'activity_type.activity_id', '=', 'user_expenses.activity_type')
                    ->select(
                            'user_expenses.*',
                            'activity_type.*',
                        )
                    ->where([
                        'user_id' => $id,
                        'paid' => 1,
                        'approver3_status' =>1,
                        'user_expenses.deleted_at' => null
                        ])
                    ->where('user_expenses.date', '>=', $start_date)
                    ->where('user_expenses.date', '<=', $end_date)
                    ->orderBy('activity_name', 'asc')
                    ->get();
        $this->getExpensesProperties($expenses); 
        return $expenses;
    }

    private function getExpensesProperties($expenses)
    {
        for ($s=0; $s <count($expenses) ; $s++) 
        { 
            $expenses[$s]->amountSpent = 0;
            $expenses[$s]->approvalStatus = $this->getExpenseApprovalStatus($expenses[$s]->expense_id);
            if($expenses[$s]->activity_type == 1)
            {
                $expenses[$s]->groupsVisited = [];
                $expenses[$s]->groupsLoans = [];
                $groupVisitationLoan = new GroupVisitationLoan();
                $groupVisitationMember = new GroupVisitationMember();
                $expenseData = GroupVisitation::getExpenseData($expenses[$s]->expense_id);
                $expenses[$s]->groupVisitDetails =  GroupVisitation::where('expense_id', $expenses[$s]->expense_id)->first();
                $expenses[$s]->amountSpent = $expenses[$s]->groupVisitDetails? $expenses[$s]->groupVisitDetails->amount_spent : 0;
                $expenses[$s]->groupsVisited = $expenses[$s]->groupVisitDetails? GroupMeeting::whereIn('meeting_id', json_decode($expenseData->groups))->get() : 0;
                $expenses[$s]->groupsLoans = $expenseData ? $groupVisitationLoan->getLoansAppliedByVisitId($expenseData->visit_id) : [];
            }

            if ($expenses[$s]->activity_type == 2) 
            {
                $expenses[$s]->appraisalData = [];
                $expenses[$s]->appraisalData = Appraisal::getAppraisalExpenseData($expenses[$s]->expense_id);
                $expenses[$s]->amountSpent = $expenses[$s]->appraisalData? $expenses[$s]->appraisalData->amount_spent : 0;
            }

            if ($expenses[$s]->activity_type == 3) 
            {
                $expenses[$s]->recoveryData = [];
                $expenses[$s]->recoveryData = LoanRecovery::getRecoveryExpenseData($expenses[$s]->expense_id);
                $expenses[$s]->amountSpent = $expenses[$s]->recoveryData? $expenses[$s]->recoveryData->amount_spent : 0;
            }

            if ($expenses[$s]->activity_type == 4) 
            {
                $expenses[$s]->followupData = [];
                $expenses[$s]->followupData = Followup::getFollowupExpenseData($expenses[$s]->expense_id);
                $expenses[$s]->amountSpent = $expenses[$s]->followupData? $expenses[$s]->followupData->amount_spent : 0;
            }
        } 
        return $expenses;
    }
    
}