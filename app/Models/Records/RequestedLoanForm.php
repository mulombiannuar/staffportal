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

    public function getLoanFormRequests($status)
    {
        return DB::table('requested_loan_forms')
                 ->join('users', 'users.id', '=', 'requested_loan_forms.requested_by')
                 //->leftJoin('loan_forms', 'loan_forms.form_id', '=', 'requested_loan_forms.request_loan_id')
                 ->join('loan_products', 'loan_products.product_id', '=', 'requested_loan_forms.product_id')
                 ->join('branches', 'branches.branch_id', '=', 'requested_loan_forms.branch_id')
                 ->join('outposts', 'outposts.outpost_id', '=', 'requested_loan_forms.outpost_id')
                 ->select(
                        'requested_loan_forms.*', 
                        //'loan_forms.*',
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'name',
                        DB::raw('(
                            CASE 
                              WHEN is_original = "0" THEN "Electronic copy" 
                              ELSE "Original copy" 
                            END
                            ) AS form_type'))
                 ->where('is_completed', $status)
                 ->orderBy('request_id', 'desc')
                 ->get();
    }

    public function getLoanFormRequestById($id)
    {
        return DB::table('requested_loan_forms')
                 ->join('users', 'users.id', '=', 'requested_loan_forms.requested_by')
                 ->join('loan_products', 'loan_products.product_id', '=', 'requested_loan_forms.product_id')
                 ->join('branches', 'branches.branch_id', '=', 'requested_loan_forms.branch_id')
                 ->leftJoin('requested_loan_form_approvals', 'requested_loan_form_approvals.request_id', '=', 'requested_loan_forms.request_id')
                 ->join('outposts', 'outposts.outpost_id', '=', 'requested_loan_forms.outpost_id')
                 ->select(
                        'requested_loan_forms.*', 
                        //'requested_loan_form_approvals.*',
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'name',
                        'loan_form_id',
                        'approved_by',
                        'approval_status',
                        'date_approved',
                        'approval_message',
                        'is_locked',
                        'viewable_deadline'
                 )
                 ->where('requested_loan_forms.request_id', $id)
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

    public function getUserRequestedLoanForms($user_id, $status)
    {
        return DB::table('requested_loan_forms')
                 ->join('users', 'users.id', '=', 'requested_loan_forms.requested_by')
                 ->leftJoin('requested_loan_form_approvals', 'requested_loan_form_approvals.request_id', '=', 'requested_loan_forms.request_id')
                 ->join('loan_products', 'loan_products.product_id', '=', 'requested_loan_forms.product_id')
                 ->join('branches', 'branches.branch_id', '=', 'requested_loan_forms.branch_id')
                 ->join('outposts', 'outposts.outpost_id', '=', 'requested_loan_forms.outpost_id')
                 ->select(
                        'requested_loan_form_approvals.*',
                        'requested_loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'name',
                 )
                 ->where(['requested_loan_forms.requested_by' => $user_id, 'is_completed' => $status])
                 ->orderBy('requested_loan_forms.request_id', 'desc')
                 ->get();
    }

}
