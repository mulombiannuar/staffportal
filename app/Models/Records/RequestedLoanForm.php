<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequestedLoanForm extends Model
{
    use HasFactory;
    protected $table = 'requested_loan_forms';
    protected $primaryKey = 'request_id';

    public function getLoanFormRequests()
    {
        return DB::table('requested_loan_forms')
                 ->join('users', 'users.id', '=', 'requested_loan_forms.requested_by')
                 ->join('loan_products', 'loan_products.product_id', '=', 'requested_loan_forms.product_id')
                 ->join('branches', 'branches.branch_id', '=', 'requested_loan_forms.branch_id')
                 ->join('outposts', 'outposts.outpost_id', '=', 'requested_loan_forms.outpost_id')
                 ->select(
                        'requested_loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'name',
                 )
                 ->orderBy('request_id', 'desc')
                 ->get();
    }

    public function getLoanFormRequestById($id)
    {
        return DB::table('requested_loan_forms')
                 ->join('users', 'users.id', '=', 'requested_loan_forms.requested_by')
                 ->join('loan_products', 'loan_products.product_id', '=', 'requested_loan_forms.product_id')
                 ->join('branches', 'branches.branch_id', '=', 'requested_loan_forms.branch_id')
                 ->join('outposts', 'outposts.outpost_id', '=', 'requested_loan_forms.outpost_id')
                 ->select(
                        'requested_loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'name',
                 )
                 ->where('request_id', $id)
                 ->first();
    }

    public function getLoanFormRequestByFormId($form_id)
    {
        return DB::table('requested_loan_forms')
                 ->join('users', 'users.id', '=', 'requested_loan_forms.requested_by')
                 ->join('loan_products', 'loan_products.product_id', '=', 'requested_loan_forms.product_id')
                 ->join('branches', 'branches.branch_id', '=', 'requested_loan_forms.branch_id')
                 ->join('outposts', 'outposts.outpost_id', '=', 'requested_loan_forms.outpost_id')
                 ->select(
                        'requested_loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'name',
                 )
                 ->where('request_loan_id', $form_id)
                 ->get();
    }

    
    public static function getLoanFormRequestsByOutpostId($outpost_id)
    {
        return DB::table('requested_loan_forms')
                 ->join('users', 'users.id', '=', 'requested_loan_forms.requested_by')
                 ->select('requested_loan_forms.*', 'name')
                 ->where('outpost_id', $outpost_id)
                 ->get();
    }

}
