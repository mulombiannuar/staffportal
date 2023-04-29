<?php

namespace App\Console\Commands;

use App\Http\Controllers\CRM\CustomerTicketController;
use App\Models\Admin;
use App\Models\CRM\CRMCustomer;
use App\Models\CRM\CustomerTicket;
use App\Models\CRM\TicketCategory;
use App\Models\CRM\TicketWorkflow;
use App\Models\Message;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncOnlineLoansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:online-loans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize online applied loans data';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $loans = [];
        try {
            //$date = date_create(date('Y-m-d'))->modify('-1 days')->format('Y-m-d');
            $date = '2023-04-28';
            $remote_url = env('WEBSITE_URL');
            $client =  new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));

            $url = $remote_url . "api/customers/v1/get-date-loans/" . $date;

            $response = $client->request('GET', $url, ['verify'  => false]);

            $loans = json_decode($response->getBody());
        } catch (\Throwable $e) {
            file_put_contents("log.txt", $e . " \n", FILE_APPEND);
        }

        //$loans = json_decode(file_get_contents(public_path("assets/docs/loans.json")), true);

        foreach ($loans as $loan) {
            $this->registerLoan($loan);
        }

        //Save audit trail
        $activity_type = 'Online Loans Data Synchronization';
        $description = 'Successfully synchronized online loans data ' . count($loans) . ' records affected';
        User::saveAutomaticAuditTrail($activity_type, $description);

        $this->info($description);
    }

    //Regsiter single loan as a ticket
    public function registerLoan($loan)
    {
        $source = 3; //Social Media Platforms 
        $category = 6; //Online Website Loans Application
        $user_id = null;
        $bimas_br_id = null;
        $outpostData = Admin::getOutpostById($loan->branch_id);
        $message = $this->setLoanApplicationMessage($loan);

        if (is_null($outpostData) || empty($outpostData)) {
            $outpost = 1;
            $branch = 1;
            $user_id = 176;
            $branchEmail = 'customercare@bimaskenya.com';
        } else {
            $outpost = $outpostData->outpost_id;
            $branchEmail = $outpostData->outpost_email ? $outpostData->outpost_email : 'customercare@bimaskenya.com';
            $branch = $outpostData->outpost_branch_id;
            $user_id = array_rand(DB::table('profiles')->where('outpost', $outpost)->pluck('user_id')->toArray());
        }

        $ticketController = new CustomerTicketController();
        $client_phone = Admin::formatMobileNumber($loan->mobile_no);

        $clientData = CRMCustomer::getClientByMobileNumber($client_phone);
        if ($clientData) $bimas_br_id = $clientData->bimas_br_id;

        //Register and get details of registered client
        $customerData = $ticketController->getRegisteredCustomerDetails($loan->name, $client_phone, $loan->location, $loan->activity, $branch, $outpost, $bimas_br_id, 1);

        // Create new ticket for the client
        $ticket = CustomerTicket::saveCustomerTicket($message, $user_id, $source, $category, $loan->application_date, $customerData->customer_id, 1);

        //Register ticket to the workflow
        CustomerTicket::newCustomerTicketWorkFlow(1, $ticket->ticket_id, 6, 13);

        $messageModel = new Message();
        $ticketCategory = TicketCategory::find($category);
        $ticket_message = $ticketController->getTicketCustomisedMessage($category);

        //Send sms notification to the officer
        $user = User::getUserById($ticket->officer_id);
        $officer_ticket_message = 'you have a new client ticket ' . $ticket->ticket_uuid . ' for ' . strtoupper($customerData->customer_name) . ' generated at the Staffportal. Login at the portal to view details. ';
        $messageModel->saveSystemMessage($ticketCategory->category_name, $user->mobile_no, $user->name,  $officer_ticket_message, true);

        //Send Customer customized sms notification
        $customer_message = $ticketController->setCustomerMessage($outpost, $ticket_message, $ticket->ticket_uuid, $user);
        $messageModel->saveSystemMessage($ticketCategory->category_name, $customerData->customer_phone, $customerData->customer_name,  $customer_message, true);

        //Send email to outpost email
        $emailSubject = 'New Customer Ticket for ' . strtoupper($customerData->customer_name) . '-' . $customerData->customer_phone . ' raised on Staffportal';
        $emailMessage = $ticketController->setOfficerMessage($ticket->message, $officer_ticket_message);
        $messageModel->SendSystemEmail($user->name, $branchEmail, $emailMessage, $emailSubject);

        return 0;
    }

    private function setLoanApplicationMessage($loan)
    {
        return 'Loan Product : ' . $loan->product_name . ', Loan Amount : ' . $loan->amount . ', and Loan Purpose : ' . $loan->loan_purpose;
    }
}
