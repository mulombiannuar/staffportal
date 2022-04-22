<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupVisitationLoan extends Model
{
    use HasFactory;
    protected $table = 'group_visitation_loans';
    protected $primaryKey = 'loan_id';

    public function getLoansAppliedByVisitId($id)
    {
       return DB::table('group_visitation_loans')->where('visit_id', $id)->get();;
    }
}