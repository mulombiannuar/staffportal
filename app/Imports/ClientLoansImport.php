<?php

namespace App\Imports;

use App\Models\Records\ClientLoan;
use App\Utilities\Utilities;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientLoansImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $loan)
    {
        return new ClientLoan([
            'client_id' => $loan['client_id'],
            'account_id' => $loan['account_id'],
            'product_id' => $loan['product_id'],
            'loan_series' => $loan['loan_series'],
            'application_id' => $loan['application_id'],
            'loan_amount' => round( $loan['loan_amount']),
            'disbursment_date' => Utilities::formatExcelToDateTimeObject($loan['disbursment_date']),
            'application_date' => Utilities::formatExcelToDateTimeObject($loan['disbursment_date']),
        ]);
    }
}
