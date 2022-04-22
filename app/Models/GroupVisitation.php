<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupVisitation extends Model
{
    use HasFactory;
    protected $table = 'group_visitations';
    protected $primaryKey = 'visit_id';

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'groups' => 'json',
    ];

    public static function getExpenseData($expense_id)
    {
        return DB::table('group_visitations')
                 ->join('user_expenses', 'user_expenses.expense_id', '=', 'group_visitations.expense_id')
                 ->where('group_visitations.expense_id', $expense_id)
                 ->first();
    }
}