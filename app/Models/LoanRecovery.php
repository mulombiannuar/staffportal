<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanRecovery extends Model
{
    use HasFactory;
    protected $table = 'loan_recoveries';
    protected $primaryKey = 'recovery_id';

    public static function getRecoveryExpenseData($expense_id)
    {
        return DB::table('loan_recoveries')
                 ->join('user_expenses', 'user_expenses.expense_id', '=', 'loan_recoveries.expense_id')
                 ->where('loan_recoveries.expense_id', $expense_id)
                 ->first();
    }
}