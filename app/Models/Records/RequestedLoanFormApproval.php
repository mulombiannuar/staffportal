<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestedLoanFormApproval extends Model
{
    use HasFactory;
    protected $table = 'requested_loan_form_approvals';
    protected $primaryKey = 'approval_id';
}
