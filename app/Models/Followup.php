<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Followup extends Model
{
    use HasFactory;
    protected $table = 'followups';
    protected $primaryKey = 'followup_id';

    public static function getFollowupExpenseData($expense_id)
    {
        return DB::table('followups')
                 ->join('user_expenses', 'user_expenses.expense_id', '=', 'followups.expense_id')
                 ->where('followups.expense_id', $expense_id)
                //  ->where('approver3_status','!=', 0)
                 ->first();
    }
}