<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestedLoanFormApproval extends Model
{
    use HasFactory;
    protected $table = 'requested_loan_form_approvals';
    protected $primaryKey = 'approval_id';

    public static function getRequestApprovalDetails($request_id)
    {
        return RequestedLoanFormApproval::join('users', 'users.id', '=', 'requested_loan_form_approvals.approved_by')
                                        ->join('requested_loan_forms', 'requested_loan_forms.request_id', '=', 'requested_loan_form_approvals.request_id')
                                        ->select(
                                            'name', 'email', 'reference',
                                            'requested_loan_form_approvals.*',
                                            'requested_loan_forms.date_requested',
                                            'requested_loan_forms.officer_message',
                                            )
                                        ->where('requested_loan_form_approvals.request_id', $request_id)
                                        ->first();
    }
}
