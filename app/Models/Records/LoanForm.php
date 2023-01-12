<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanForm extends Model
{
    use HasFactory;
    protected $table = 'loan_forms';
    protected $primaryKey = 'form_id';

    public static function getLoanFormById($form_id)
    {
        return LoanForm::join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                       ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                       ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                       ->join('filing_types', 'filing_types.type_id', '=', 'loan_forms.filing_type_id')
                       ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                       ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                       //->select('clients.*', 'users.name as created_by', 'branch_name', 'outpost_name')
                       ->where(['form_id'=> $form_id])
                       ->first();
    }

    public static function getLoanForms()
    {
        return LoanForm::join('users', 'users.id', '=', 'loan_forms.created_by')
                    ->join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                    ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                    ->join('filing_types', 'filing_types.type_id', '=', 'loan_forms.filing_type_id')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'file_label',
                        'type_name',
                        'filing_labels.file_number as filing_number',
                        )
                    ->orderBy('bimas_br_id', 'asc')
                    ->get();
    }

    public static function getLoanFormsByType($type_id)
    {
        return LoanForm::join('users', 'users.id', '=', 'loan_forms.created_by')
                    ->join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                    ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                    ->join('filing_types', 'filing_types.type_id', '=', 'loan_forms.filing_type_id')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'file_label',
                        'type_name',
                        'filing_labels.file_number as filing_number',
                        )
                    ->where('filing_type_id', $type_id)
                    ->orderBy('bimas_br_id', 'asc')
                    ->get();
    }

    public static function getLoanFormsByFileNumber($file_number)
    {
        return LoanForm::join('users', 'users.id', '=', 'loan_forms.created_by')
                     ->join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                     ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                     ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                     ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                     ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                     ->select(
                        'clients.*', 
                        'loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'file_label',
                        'filing_labels.file_number as filing_number',
                        )
                     ->where('loan_forms.file_number', $file_number)
                     ->orderBy('bimas_br_id', 'asc')
                     ->get();
    }

    public static function getRequestedLoanForm($client_id, $product_id, $amount, $date)
    {
        return LoanForm::join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                       ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                       //->select('clients.*', 'users.name as created_by', 'branch_name', 'outpost_name')
                       ->where([
                            'amount' => $amount,
                            'loan_forms.client_id'=> $client_id,
                            'loan_forms.product_id' => $product_id,
                            'disbursment_date' => $date
                        ])
                       ->first();
    }
}
