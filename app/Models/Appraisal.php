<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appraisal extends Model
{
    use HasFactory;
    protected $table = 'appraisals';
    protected $primaryKey = 'appraisal_id';

    public static function getAppraisalExpenseData($expense_id)
    {
        return DB::table('appraisals')
                 ->join('user_expenses', 'user_expenses.expense_id', '=', 'appraisals.expense_id')
                 ->where('appraisals.expense_id', $expense_id)
                 ->first();
    }

    
}