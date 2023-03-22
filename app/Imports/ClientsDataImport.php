<?php

namespace App\Imports;

use App\Models\Admin;
use App\Models\Records\Client;
use App\Utilities\Utilities;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsDataImport implements ToCollection, WithHeadingRow
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $clients)
    {
        $branch_id = 16;
        $outpost_id = 40;
        foreach ($clients as $client) 
        {
            $client_id = $client['client_id'];
            if (!is_null($client_id)) 
            {
                $clientData = Client::where('bimas_br_id', $client_id)->first();
                if (is_null($clientData) || empty($clientData))  
                {
                    // $outpostData = Admin::getOutpostByName(ucwords($client['outpost_id']));
                    $registration_date = Utilities::formatExcelToDateTimeObject($client['registration_date']);

                    // if (!is_null($outpostData) || !empty($outpostData)) {
                    //     $outpost_id = $outpostData->outpost_id;
                    //     $branch_id = $outpostData->outpost_branch_id;
                    // }
    
                    DB::table('clients')->insert([
                        'bimas_br_id' => $client_id,
                        'client_name' => $client['client_name'],
                        'client_phone' => $client['client_phone'],
                        'national_id' => $client['national_id'],
                        'branch_id' => $branch_id,
                        'outpost_id' => $outpost_id,
                        'registration_date' => $registration_date,
                        'created_by' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                else{

                    DB::table('clients')->where('bimas_br_id', $client_id)->update([
                        'branch_id' => $branch_id,
                        'outpost_id' => $outpost_id,
                    ]);

                }
            }
        }
    }
}
