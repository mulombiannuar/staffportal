<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLoan extends Model
{
    use HasFactory;
    protected $table = 'client_loans2';
    protected $fillable = [
        'client_id',
        'account_id',
        'product_id',
        'application_id',
        'loan_amount',
        'loan_series',
        'disbursment_date',
        'application_date',
        'created_at'
    ];
}
