<?php

namespace App\Console\Commands;

use App\Models\CRM\CustomerTicket;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SyncOnlineSurveyDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:survey-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize online survey data';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $customerTicket = new CustomerTicket();
        try {
            $client =  new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
            $url = env('FEEDBACK_URL') . "api/customer-feedback/v1/get/synced/0";

            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $data = json_decode($response->getBody());
            $customerTicket->syncSurveyData($data);
        } catch (\Throwable $th) {
            file_put_contents(storage_path('logs/system_logs.txt'), $th . " \n", FILE_APPEND);
        }

        //Save audit trail
        $activity_type = 'Survey Data Synchronization';
        $description = 'Successfully synchronized customer survey data ' . count($data) . ' records affected';
        User::saveAutomaticAuditTrail($activity_type, $description);

        $this->info($description);
    }
}
