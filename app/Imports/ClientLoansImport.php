<?php

namespace App\Imports;

use App\Models\Records\ClientLoan;
use App\Utilities\Utilities;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientLoansImport implements ToCollection, WithHeadingRow
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $loans)
    {
        foreach ($loans as $loan) 
        {
            DB::table('client_loans')->insert([
                'client_id' => $loan['client_id'],
                'account_id' => $loan['account_id'],
                'product_id' => $loan['product_id'],
                'loan_series' => $loan['loan_series'],
                'application_id' => $loan['application_id'],
                'loan_amount' => round($loan['loan_amount']),
                'disbursment_date' => Utilities::formatExcelToDateTimeObject($loan['disbursment_date']),
                'application_date' => Utilities::formatExcelToDateTimeObject($loan['disbursment_date']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
